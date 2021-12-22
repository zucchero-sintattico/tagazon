from bs4 import BeautifulSoup # BeautifulSoup is in bs4 package 
import json, time, os, requests
from os import listdir
from os.path import isfile, join
from multiprocessing import Process, Manager


THREADS = 8

def getTags():
    mypath = os.path.join(os.path.dirname(os.path.abspath(__file__)), 'categories')
    files = [f for f in listdir(mypath) if isfile(join(mypath, f))]
    tags = dict()
    for file in files:
        category = file.replace('.txt', '')
        with open(os.path.join(mypath, file), 'r') as f:
            ts = [t.replace('\n', '') for t in f.readlines()]
            for t in ts:
                if t not in tags:
                    tags[t] = {'categories': [category, ]}
                else:
                    tags[t]['categories'].append(category)
    return tags

def getTagDescription(tag):
    url = f'https://html.com/tags/{tag}'
    content = requests.get(url)
    soup = BeautifulSoup(content.text, 'html.parser')
    row = soup.find_all('dd')
    if len(row) > 0:
        if row[0].get_text().startswith('The'): 
            row = row[0]
        else:
            row = row[1]        
        return row.get_text()
    return None

def beautifyCode(code):
    soup = BeautifulSoup(code, features="lxml")
    code = soup.prettify()
    return code

def getTagExampleAndExampleDescription(tag):
    url = f"https://www.w3schools.com/TAGS/tag_{tag}.asp"
    content = requests.get(url)
    if content.status_code == 200:
        soup = BeautifulSoup(content.text, 'html.parser')
        row = soup.find('div', {'class': 'w3-example'})
        example_desc = row.find('p').get_text()
        example = row.find('div', {'class' : 'w3-code notranslate htmlHigh'}).get_text()
        return example, example_desc
    return None, None

def scraping(tags, output, index):
    for tag in tags:
        print(f'Thread {index} - {tag}', flush=True)
        desc = getTagDescription(tag)
        example, example_desc = getTagExampleAndExampleDescription(tag)
        example = beautifyCode(example)
        output[tag] = {
            'categories': output[tag]['categories'],
            'description': desc,
            'example': example,
            'example_desc': example_desc
        }
        


if __name__ == '__main__':
    manager = Manager()
    tags = getTags()
    output = dict()
    for key in list(tags.keys()):
        output[key] = tags[key]
    output = manager.dict(output)
    ps = []
    elementPerThread = int(len(output)/THREADS) + 1
    splittedTags = [list(tags.keys())[i*elementPerThread:(i+1)*elementPerThread] for i in range(0, THREADS)]
    for splitTags in splittedTags:
        p = Process(target=scraping, args=(splitTags, output, splittedTags.index(splitTags) + 1))
        ps.append(p)
        p.start()

    for p in ps:
        p.join()

    with open(os.path.join(os.path.dirname(os.path.abspath(__file__)), 'output.json'), 'w') as f:
        f.write(json.dumps(dict(output), indent=4))