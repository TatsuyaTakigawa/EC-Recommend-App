import os
os.environ['TF_USE_LEGACY_KERAS'] = '1'
os.environ['TF_ENABLE_ONEDNN_OPTS']='0'

import pandas as pd
import tensorflow as tf
import tensorflow_recommenders as tfrs

# CSVを読み込む
df_user = pd.read_csv("flask_api/data/user.csv")
df_item = pd.read_csv("flask_api/data/item.csv")

# TensorFlow Datasetに変換
dataset_user = tf.data.Dataset.from_tensor_slices({
    "user_id": df_user["USER_ID"].astype(str).tolist(),
    "user_name": df_user["USER_NAME"].astype(str).tolist()
})
dataset_item = tf.data.Dataset.from_tensor_slices({
    "item_id": df_item["ITEM_ID"].astype(str).tolist(),
    "item_name": df_item["ITEM_NAME"].astype(str).tolist()
})

user_vocab = df_user["USER_ID"].astype(str).unique().tolist()
item_vocab = df_item["ITEM_ID"].astype(str).unique().tolist()

user_layer = tf.keras.layers.StringLookup(vocabulary=user_vocab, mask_token=None)
item_layer = tf.keras.layers.StringLookup(vocabulary=item_vocab, mask_token=None)

class RecommenderModel(tfrs.Model):
    def __init__(self):
        super().__init__()

        # USER_IDを埋め込みに変換するモデル
        self.query_model = tf.keras.Sequential([
            user_layer,  # 数値IDに変換
            tf.keras.layers.Embedding(len(user_vocab)+1, 64)  # 埋め込み層
        ])

        # ITEM_IDを埋め込みに変換するモデルモデル
        self.candidate_model = tf.keras.Sequential([
            item_layer,  # 数値IDに変換
            tf.keras.layers.Embedding(len(item_vocab)+1, 64)  # 埋め込み層
        ])

        # 損失関数
        self.task = tfrs.tasks.Retrieval(
            metrics=tfrs.metrics.FactorizedTopK(
                candidates=tf.data.Dataset.from_tensor_slices(item_vocab).batch(32).map(self.candidate_model)
            )
        )

    def compute_loss(self, features, training=False):
        user_embeddings = self.query_model(features["user_id"])
        item_embeddings = self.candidate_model(features["item_id"])
        return self.task(user_embeddings, item_embeddings)
