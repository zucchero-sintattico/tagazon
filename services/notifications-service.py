#!/usr/bin/python3

import requests
import paho.mqtt.client as mqtt
from time import sleep
import json, sys

website = 'localhost/tagazon/src'
if len(sys.argv) > 1:
    website = sys.argv[1]
    
url = f'http://{website}/api/objects/notifications/news/'
delay = 1

class Mqtt:
    
    transport = "websockets"
    server = "broker.emqx.io"
    port = 8083
    topic = "tagazon-notifications"

    def __init__(self):
        self.client = mqtt.Client(transport=self.transport)
    
    def connect(self):
        self.client.connect(self.server, self.port)
    
    def publish(self, buyerId):
        topic = f'{self.topic}/{buyerId}'
        print(f'Publishing to {topic}')
        self.client.publish(topic, "NEW", qos=1)

mqttClient = Mqtt()
mqttClient.connect()
while True:
    response = requests.get(url)
    buyers = json.loads(response.text)["data"]["buyers"]
    for buyerId in buyers:
        #print("Sending notification to buyer: " + str(buyerId))
        mqttClient.publish(str(buyerId))
    sleep(delay)