class Person:
    """
    Represents a person, holds name, client and IP address
    """
    def __init__(self,addr,client):
        self.addr = addr
        self.client = client
        self.name = None

    def __set_name__(self,name):
        """
        sets the persons name
        :param name: str
        :return: None
        """
        self.name = name

    def __repr__(self):
        return f"Person({self.addr},{self.name})"


