from client import Client
import time
from threading import Thread



c1 = Client("Ed")
c2 = Client("Jay")


def update_messages():
    """
    updates the local list of messages
    :return: None
    """
    msgs = []
    run = True
    while run:
        time.sleep(0.1)  # update every 1/10 of a second
        new_messages = c1.get_messages()  # get any new messages from client
        msgs.extend(new_messages)  # add to local list of messages

        for msg in new_messages:  # display new messages
            print(msg)

            if msg == "{quit}":
                run = False
                break


Thread(target=update_messages).start()

c1.send_message("Hello")
time.sleep(5)
c2.send_message("Whats up")
time.sleep(5)
c1.send_message("nothing, hbu ?")
time.sleep(5)
c2.send_message("Boring...")

c1.disconnect()
time.sleep(3)
c2.disconnect()
