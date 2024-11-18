import subprocess

url = "http://ip-address/index.php?data="

user_data = input("Message: ")

p = subprocess.run("curl " + url + data, capture_output=True, shell=True)
website_output = str(p.stdout)

start = website_output.find("[") + 1
end = website_output.find("]")
returned_data = website_output[start:end]

output_file = open("morse-data", "w")
output_file.write(returned_data)
output_file.close()
