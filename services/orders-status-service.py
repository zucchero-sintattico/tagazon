import requests, json
import time
from time import sleep
from datetime import datetime

received_url = 'http://localhost/tagazon/src/api/objects/orders/?status=RECEIVED&python-bot'
processing_url = 'http://localhost/tagazon/src/api/objects/orders/?status=PROCESSING&python-bot'
shipped_url = 'http://localhost/tagazon/src/api/objects/orders/?status=SHIPPED&python-bot'
delivering_url = 'http://localhost/tagazon/src/api/objects/orders/?status=DELIVERING&python-bot'

delay = 3

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
    requests.patch('http://localhost/tagazon/src/api/objects/orders/&python-bot', order)

def checkOrderAndSetStatus(order, nextStatus):
    timestamp = datetime.strptime(order["timestamp"], "%Y-%m-%d %H:%M:%S")
    if ((datetime.now() - timestamp).total_seconds() >= 2):
        url = 'http://localhost/tagazon/src/api/objects/orders/?python-bot'
        data = {
            "id": order["id"],
            "status": nextStatus,
            "timestamp": datetime.now()
        }
        response = requests.patch(url, data)
        if response.status_code == 200:
            print(f'The status of order {order["id"]} has been changed to {nextStatus}')
        else:
            print('Error')
            
def checkOrdersAndSetStatus(orders, nextStatus):
    for order in orders:
        checkOrderAndSetStatus(order, nextStatus)
        
    
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