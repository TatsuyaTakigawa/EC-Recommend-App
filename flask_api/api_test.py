import requests

url = "http://xxxxxxxxxxxxxxx/predict"
payload = { "user_id" : "3" }

response = requests.post(url, json=payload)
print(response.json())