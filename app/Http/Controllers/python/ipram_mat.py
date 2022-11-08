import http.client
import paramiko 

def sharepoint():
    
    headers = {'apikey': 'gqDucyLyTp8LUtvMEr7guBX6EPMIfHMJ'}

    conn = http.client.HTTPConnection('matcnocw.claro.amx')
    conn.request(method='GET',url='/api/v1/inventory/service/swdiscovery', headers=headers)
    res = conn.getresponse()

    data = res.read()
    # print(res.status, res.reason)
    # print(data.decode('utf-8'))
    # print(res.getheaders())

def connect_to_bifrost():
    host = "172.16.254.100"
    port = "22"
    username = "CTI22541"
    password = "C@b2022@"
    ssh_client = paramiko.SSHClient()
    ssh_client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh_client.connect(host,port,username,password)
    # entrada, salida, error = ssh_client.exec_command('fping -g 10.210.68.0/27')
    entrada, salida, error = ssh_client.exec_command('fping -g 10.210.68.0/27')
    print (salida.read())
    ssh_client.close()

if __name__ == '__main__':
    connect_to_bifrost()

