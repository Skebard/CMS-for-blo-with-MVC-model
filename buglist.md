# Editor page
1. If there is no main category selected then the last main category will be send in the http request to the server
2. The main category is as well send in the categories field.
3. When sending code if the programming language selection have not been selected the default value is not send to the server
4. When saving without any secondary category there is a sql error in the server  --FIXED
5. Many errors when sending empty fields (as in 4).
6. When loading the editor the right code language is not selected. For example you saved code in PHP then you refresh  the editor and in the select it will appear javascript (but it will be saved as PHP).
7.When saving a post with empty content there is an SQL error -> empty query.However, the functionality works.
8.If post fields ar empty many notices appear