#!/usr/bin/python3

data = "<base>, <command>, <link>, <meta>, <noscript>, <script>, <style>, <title>";

data = data.replace('<', '').replace('>', '').replace(', ', ' ').split(' ')
for el in data:
    print(el)

