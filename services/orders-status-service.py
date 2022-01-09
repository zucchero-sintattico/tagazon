import requests, json
import time, sys
from time import sleep
from datetime import datetime


website = 'localhost/tagazon/src'
if len(sys.argv) > 1:
    website = sys.argv[1]


received_url = f'http://{website}/api/objects/orders/?status=RECEIVED&python-bot'
processing_url = f'http://{website}/api/objects/orders/?status=PROCESSING&python-bot'
shipped_url = f'http://{website}/api/objects/orders/?status=SHIPPED&python-bot'
delivering_url = f'http://{website}/api/objects/orders/?status=DELIVERING&python-bot'

delay = 10

def getObjects(url):
    return requests.get(url).json()["data"]

def getNextStatus(status):
    if status == "RECEIVED":
        return "PROCESSING"
    elif status == "PROCESSING":
        return "SHIPPED"
    elif status == "SHIPPED":
        return "DELIVERING"
    elif status == "DELIVERING":
        return "DELIVERED"
    
def setStatus(order, status):
    order["status"] = status
    requests.put(f'http://{website}/api/objects/orders/&python-bot', order)

def buildMessageTitle(order, status):
    if status == "PROCESSING":
        return f"Order #{order['id']}: received"
    elif status == "SHIPPED":
        return f"Order #{order['id']}: shipped"
    elif status == "DELIVERING":
        return f"Order #{order['id']}: delivering"
    elif status == "DELIVERED":
        return f"Order #{order['id']}: delivered"
    
def buildMessageBody(order, status):
    if status == "PROCESSING": 
        return f"Dear customer, your order #{order['id']} has been received. \nWe are processing it. \nIt will be shipped soon."
    elif status == "SHIPPED":
        return f"Dear customer, your order #{order['id']} has been shipped. \nIt will arrive soon."
    elif status == "DELIVERING":
        return f"Dear customer, your order #{order['id']} is being delivered to the address: Via dell' Università 50, 47522, Cesena(FC), Italy."
    elif status == "DELIVERED":
        return f"Dear customer, your order #{order['id']} has been delivered to the address: Via dell' Università 50, 47522, Cesena(FC), Italy.\nThank you for choosing Tagazon."

def checkOrderAndSetStatus(order, nextStatus):
    url = f'http://{website}/api/objects/orders/?python-bot'
    data = {
        "id": order["id"],
        "status": nextStatus,
    }
    response = requests.put(url, data)
    if response.status_code == 200:
        sendNotification(order, nextStatus)
        print(f'The status of order {order["id"]} has been changed to {nextStatus}')
    else:
        print('Error')
            
def checkOrdersAndSetStatus(orders, nextStatus):
    for order in orders:
        checkOrderAndSetStatus(order, nextStatus)
        

def sendNotification(order, nextStatus):
    title = buildMessageTitle(order, nextStatus)
    body = buildMessageBody(order, nextStatus)
    data = {
        "order": order["id"],
        "title": title,
        "message": body
    }
    url = f'http://{website}/api/objects/notifications/?python-bot'
    response = requests.post(url, data)
    if response.status_code == 201:
        print(f'Notification has been sent')
    else:
        print('Error')

while True:
    
    print('Checking orders...')
    
    received = getObjects(received_url)
    processing = getObjects(processing_url)
    shipped = getObjects(shipped_url)
    delivering = getObjects(delivering_url)
    
    checkOrdersAndSetStatus(received, "PROCESSING")
    checkOrdersAndSetStatus(processing, "SHIPPED")
    checkOrdersAndSetStatus(shipped, "DELIVERING")
    checkOrdersAndSetStatus(delivering, "DELIVERED")
    
    sleep(delay)
