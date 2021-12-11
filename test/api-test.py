import unittest
from json import loads, dumps
from requests import get, post, patch, delete

API = 'http://localhost/tagazon/src/api/'

class TagTest(unittest.TestCase):
    
    PATH = 'tags/'

    def test_get_all(self):
        url = API + self.PATH
        response = get(url)
        data = loads(response.text)
        self.assertTrue(len(data) > 0)
    
    def test_get_one(self):
        url = API + self.PATH
        response = get(url)
        data = loads(response.text)
        id = int(data[0]['id'])
        response = get(url, params={'id': id})
        data = loads(response.text)
        self.assertEqual(data[0]['id'], id)


if __name__ == '__main__':
    unittest.main()