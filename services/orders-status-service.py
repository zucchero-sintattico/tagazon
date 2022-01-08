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
    return f'The status of order {order["id"]} has been changed to {status}'
def buildMessageBody(order, status):
    return f'The status of order {order["id"]} has been changed to {status}'

def checkOrderAndSetStatus(order, nextStatus):
    timestamp = datetime.strptime(order["timestamp"], "%Y-%m-%d %H:%M:%S")
    if ((datetime.now() - timestamp).total_seconds() >= 2):
        url = f'http://{website}/api/objects/orders/?python-bot'
        data = {
            "id": order["id"],
            "status": nextStatus,
            "timestamp": datetime.now()
        }
        response = requests.put(url, data)
        if response.status_code == 200:
            sendNotification(order, nextStatus)
            print(f'The status of order {order["id"]} has been changed to {nextStatus}')
        else:
            print(response.text)
            print('Error')
            
def checkOrdersAndSetStatus(orders, nextStatus):
    for order in orders:
        checkOrderAndSetStatus(order, nextStatus)
        

def sendNotification(order, nextStatus):
    title = f"Order #{order['id']}: {nextStatus.lower().capitalize()}";
    body = f"Dear customer, your order #{order['id']} has been {nextStatus.lower()}. \nThank you for choosing Tagazon.";
    data = {
        "order": order["id"],
        "title": title,
        "message": body
    }
    url = f'http://{website}/api/objects/notifications/?python-bot'
    response = requests.post(url, data)
    print(response.text)
    if response.status_code == 200:
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
