#!/usr/bin/python3

import requests
import paho.mqtt.client as mqtt
from time import sleep
import json, sys

website = 'localhost/tagazon/src'
if len(sys.argv) > 1:
    website = sys.argv[1]
    
url = f'http://{website}/api/objects/notifications/news/'
delay = 2

class Mqtt:
    
    transport = "websockets"
    server = "broker.emqx.io"
    port = 8083
    topic = "tagazon-notifications"

    def __init__(self):
        self.client = mqtt.Client(transport=self.transport)
        self.connected_flag=False
    
    def connect(self):
        self.client.on_connect = self.on_connect
        self.client.connect(self.server, self.port)
        while not self.connected_flag: #wait in loop
            print("In wait loop")
            sleep(1)
    
    def publish(self, buyerId):
        topic = f'{self.topic}/{buyerId}'
        print(f'Publishing to {topic}')
        print(self.client.publish(topic, "NEW", qos=1))
        
    def on_connect(client, userdata, flags, rc):
        if rc==0:
            self.connected_flag=True #set flag
            print("connected OK Returned code=",rc)
        else:
            print("Bad connection Returned code=",rc)
while True:
    print('Checking for new notifications...')
    mqttClient = Mqtt()
    mqttClient.connect()
    response = requests.get(url)
    buyers = json.loads(response.text)["data"]
    for buyerId in buyers:
        #print("Sending notification to buyer: " + str(buyerId))
        mqttClient.publish(str(buyerId))
    sleep(delay)