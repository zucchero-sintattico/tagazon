import unittest, os
from json import loads, dumps
from requests import get, post, patch, delete

API = 'http://localhost/tagazon/src/api/'

class EntityTest():

    def test_get_all(self):
        url = API + self.PATH
        response = get(url)
        self.assertEqual(response.status_code, 200)
    
    def test_get_one(self):
        url = API + self.PATH
        response = get(url)
        self.assertEqual(response.status_code, 200)
        try:
            data = loads(response.text)
            id = int(data[0]['id'])
            response = get(url, params={'id': id})
            data = loads(response.text)
            self.assertEqual(data[0]['id'], id)
        except: 
            pass




if __name__ == '__main__':
    entities = os.listdir('../src/api/')
    for entity in entities:
        # check if it's a directory
        if os.path.isdir('../src/api/' + entity):
            exec(f"""class {entity}Test(EntityTest, unittest.TestCase):
                        PATH = '{entity}/'
                """)
        
    unittest.main()