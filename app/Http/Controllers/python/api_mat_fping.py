import requests
import ssl
import http.client
import json


def post_fping(ip_address, mask):
    try:
            _create_unverified_https_context = ssl._create_unverified_context
    except AttributeError:
        # Legacy Python that doesn't verify HTTPS certificates by default
            pass
    else:
        # Handle target environment that doesn't support HTTPS verification
            ssl._create_default_https_context = _create_unverified_https_context

    url_post = 'https://matef.claro.amx/mat/api/v2/networktask/c5y-684-l1l/env/sandbox/jobs/sync'
    headers = {'apikey': 'ZbONXBQ9JRkm3QZm9KzrAR1SNplM6D7L', 'accept': 'application/json', 'Content-Type': 'application/json'}
    data_post = '{"form_data":{"ipv4":"'+ip_address+'","mask":"'+mask+'"}}'

    coon = http.client.HTTPSConnection('matef.claro.amx')
    coon.request(method='POST', url=url_post, body=data_post, headers=headers)
    res = coon.getresponse()
    data_json = res.read()
    jsondecoded = json.loads(data_json)
    return jsondecoded

if __name__ == '__main__':
    ip_address = input("Escriba el rango IP:")
    mask = input("Mascara:")
    print (post_fping(ip_address,mask))

# url_get = 'https://matef.claro.amx/mat/api/v2/networktask/c5y-684-l1l/env/sandbox/jobs/aev-y6k-zk3'
# coon.request(method='GET', url=url_get, headers=headers, encode_chunked=False)

# response = requests.get(url)
