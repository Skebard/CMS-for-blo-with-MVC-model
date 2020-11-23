# Editor page
1. If there is no main category selected then the last main category will be send in the http request to the server
2. The main category is as well send in the categories field.
3. When sending code if the programming language selection have not been selected the default value is not send to the server
4. When saving without any secondary category there is a sql error in the server  --FIXED
5. Many errors when sending empty fields (as in 4).