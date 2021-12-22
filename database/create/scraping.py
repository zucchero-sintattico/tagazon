from bs4 import BeautifulSoup # BeautifulSoup is in bs4 package 
import json, time, os, requests
from os import listdir
from os.path import isfile, join
from multiprocessing import Process, Manager


THREADS = 8

def getTags():
    mypath = os.path.join(os.path.dirname(os.path.abspath(__file__)), 'categories')
    files = [f for f in listdir(mypath) if isfile(join(mypath, f))]
    tags = []
    for file in files:
        with open(os.path.join(mypath, file), 'r') as f:
            ts = [t.replace('\n', '') for t in f.readlines()]
            for t in ts:
                if not t in tags:
                    tags.append(t)
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
        res = dict({'tag': tag})
        res['description'] = getTagDescription(tag)
        res['example'], res['example_desc'] = getTagExampleAndExampleDescription(tag)
        output[tag] = res
        


if __name__ == '__main__':
    tags = getTags()
    ps = []
    manager = Manager()
    output = manager.dict()
    elementPerThread = int(len(tags)/THREADS) + 1
    splittedTags = [tags[i*elementPerThread:(i+1)*elementPerThread] for i in range(0, THREADS)]
    for splitTags in splittedTags:
        p = Process(target=scraping, args=(splitTags, output, splittedTags.index(splitTags) + 1))
        ps.append(p)
        p.start()

    for p in ps:
        p.join()

    
    with open(os.path.join(os.path.dirname(os.path.abspath(__file__)), 'tags.json'), 'w') as f:
        f.write(json.dumps(output.values()))