from recommender import *
from flask import Flask, request, jsonify
import numpy as np

model = RecommenderModel()
model.load_weights('model/weights') # 学習済みの重みの読み込み
index = tfrs.layers.factorized_top_k.BruteForce(model.query_model)
index.index_from_dataset(
    tf.data.Dataset.from_tensor_slices(item_vocab).batch(100).map(lambda item_id:(item_id, model.candidate_model(item_id)))
)

app = Flask(__name__)

@app.route("/")
def home():
    return jsonify({"message": "Flask TensorFlow API is running"})

@app.route("/predict", methods=["POST"])
def predict():
    try:
        data = request.get_json()
        user_id = data["user_id"]
        # ユーザー ID を TensorFlow の入力に変換
        user_tensor = tf.constant([user_id])
        # 推論実行
        scores, item_id = index(user_tensor) #user_idに対するおすすめのitem_idの取得
        byte_list=item_id[0].numpy().tolist()
        int_list = [int(byte.decode()) for byte in byte_list]
        return jsonify({"predictions": int_list})
    except Exception as e:
        return jsonify({"error": str(e)})

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=8000, debug=False)
