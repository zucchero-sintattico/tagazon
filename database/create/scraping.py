from bs4 import BeautifulSoup # BeautifulSoup is in bs4 package 
import requests
import os
from os import listdir
from os.path import isfile, join
import json

mypath = os.path.join(os.path.dirname(os.path.abspath(__file__)), 'categories')
files = [f for f in listdir(mypath) if isfile(join(mypath, f))]

tags = []
for file in files:
    with open(os.path.join(mypath, file), 'r') as f:
        ts = [t.replace('\n', '') for t in f.readlines()]
        for t in ts:
            if not t in tags:
                tags.append(t)

output = []
for tag in tags:
    
    res = dict()
    res['name'] = tag
    
    print(f"Tag: {tag} [{tags.index(tag) + 1}/{len(tags)}]")
    
    
    url = f'https://html.com/tags/{tag}'
    content = requests.get(url)
    soup = BeautifulSoup(content.text, 'html.parser')
    row = soup.find_all('dd')
    res['description'] = ''
    if len(row) > 0:
        if row[0].get_text().startswith('The'): 
            row = row[0]
        else:
            row = row[1]        
        res['description'] = row.get_text()
    
    url = f"https://www.w3schools.com/TAGS/tag_{tag}.asp"
    content = requests.get(url)
    res['example'] = ''
    if content.status_code == 200:
        soup = BeautifulSoup(content.text, 'html.parser')
        row = soup.find('div', {'class' : 'w3-code notranslate htmlHigh'})
        res['example'] = row.get_text()
    
    output.append(res)

# write output variable on a json file
with open('output.json', 'w') as f:
    json.dump(output, f, indent=4)