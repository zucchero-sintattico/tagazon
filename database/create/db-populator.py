import os, requests, json, random, sys
from passlib.hash import bcrypt
from multiprocessing import Process

"""
Configuration
"""

website = 'tagazon.altervista.org' # 'localhost/tagazon/src'
if len(sys.argv) > 1:
    website = sys.argv[1]
    
path = f'http://{website}/api/objects/'
end = '?python-bot';
SELLERS = 10
BUYERS = 10



# ----------------------------------------------------------------------------------------------------------------------
# ----------------------------------------------------------------------------------------------------------------------
# ----------------------------------------------------------------------------------------------------------------------

"""
CODE
"""

def sellers(num):
    url = path + '../users/register/' + end
    w3c = {
            "rag_soc": "World Wide Web Consortium",
            "piva": "12345678901",
            "email": "w3c@email.com",
            "password": "password"
    }
    requests.post(url, w3c)
    for i in range(num):
        seller = {
            "rag_soc": "Seller" + str(i),
            "piva": "123456789" + str(i),
            "email": "seller" + str(i) + "@email.com",
            "password": "password"
        }
        res = requests.post(url, seller)
        print(res.text)
        print(f'Seller: {res.json()}')

def buyers(num):
    url = path + '../users/register/' + end
    for i in range(num):
        buyer = {
            "name": "Buyer" + str(i),
            "surname": "Surname" + str(i),
            "email": "buyer" + str(i) + "@email.com",
            "password": "password"
        }
        res = requests.post(url, buyer)
        print(f'Buyer: {res.json()}')
    
def categories():
    url = path + 'categories/' + end
    jsonPath = os.path.join(os.path.dirname(os.path.abspath(__file__)), 'categories.json')
    with open(jsonPath) as f:
        data = json.load(f)
    for category in data:
        res = requests.post(url, category)
        print(f"Categories : {res.json()}")

def tags():
    def getRandomPrice():
        return round(random.uniform(0, 40), 2)
    def getRandomSalePrice(price):
        if random.randint(0, 1):
            return round(price - random.uniform(0, price), 2)
        return None
    url = path + 'tags/' + end
    jsonPath = os.path.join(os.path.dirname(os.path.abspath(__file__)), 'tags.json')
    with open(jsonPath) as f:
        data = json.load(f)
    for tag in data:
        price = getRandomPrice()
        res = requests.post(url, {
            'name': tag['name'],
            'description': tag['description'],
            'example': tag['example'],
            'example_desc': tag['example_desc'],
            'seller': 1,
            'price': price,
            'sale_price': getRandomSalePrice(price),
        })
        print(f"Tags : {res.json()}")

def tags_categories():
    url = path + 'tags-categories/' + end
    jsonPath = os.path.join(os.path.dirname(os.path.abspath(__file__)), 'tags.json')
    with open(jsonPath) as f:
        data = json.load(f)
    for tag in data:
        tagId = requests.get(path + 'tags/' + end + '&name=' + tag['name']).json()['data'][0]['id']
        for category in tag['categories']:
            categoryId = requests.get(path + 'categories/' + end + '&name=' + category).json()['data'][0]['id']
            res = requests.post(url, {
                'tag': tagId,
                'category': categoryId
            })
            print(f'Tags_Categories: {res.json()}')        

ps = []
def executeInThread(target, args):
    p = Process(target=target, args=args)
    ps.append(p)
    p.start()

def executeSync(target, args=()):
    target(*args)
    
if __name__ == '__main__':
    executeSync(sellers, (SELLERS,))
    executeSync(buyers, (BUYERS,))    
    executeSync(categories)
    executeSync(tags)
    executeSync(tags_categories)
    for p in ps:
        p.join()
    
    