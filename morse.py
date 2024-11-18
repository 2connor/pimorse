import os
import time

led_pin = "23"
buzzer_pin = "24"
input_file = open("morse-data", "r")

data = input_file.read()

os.system("sudo gpio -g mode " + led_pin + " output")
os.system("sudo gpio -g mode " + buzzer_pin + " output")

user_input = input("led or buzzer: ")

if (user_input == "buzzer"):
        for c in data:
                os.system("sudo gpio -g write " + buzzer_pin + " " + c)
		# optional delay
		# time.sleep(0.1)
else:
        for c in data:
                os.system("sudo gpio -g write " + led_pin + " " + c)
		# time.sleep(0.1)

input_file.close()
