import requests

url = "http://127.0.0.1:8000/predict"
payload = { "user_id" : "3" }

response = requests.post(url, json=payload)
print(response.json())