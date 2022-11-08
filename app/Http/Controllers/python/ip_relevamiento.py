import http.client
import paramiko 
import re
from time import time

def connect_to_bifrost():
    host = "172.16.254.100"
    port = "22"
    username = "matusercnoc"
    password = "Claro.arg"
    ssh_client = paramiko.SSHClient()
    ssh_client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh_client.connect(host,port,username,password)
    entrada, salida, error = ssh_client.exec_command('fping -g 10.210.2.0/25')
    ips = salida.read().decode('ascii')
    check = ip_regx(ips)
    print(check)
    ssh_client.close()

def ip_regx(rango):
    patron = r'[\d\.]+[\s][a-z\s]*'
    # patron = r'([\d\.]+)?(\w{4,11})?' #buscar la ip y el estado
    alive_unreachable = re.findall(patron, rango)
    list_ipx = []
    for ipx in alive_unreachable:
        rango_clear = ipx#.group(0)
        list_ipx.append(rango_clear.rstrip())
    
    return list_ipx

if __name__ == '__main__':
    start_time = time()
    connect_to_bifrost()
    end_time = time() - start_time
    print(end_time)