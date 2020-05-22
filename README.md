# Sistema de Gestão de Transportes

## Tecnologias utilizadas:
* PHP 5
* JQuery 3.3.1
* MySQL 5.3
* Framework Code Igniter 2 (PHP 5.1+)
* Framework Boostrap v. 4.3.1 (CSS)
* DataTables v. 1.10.19

Este é o Sistema de Gerenciamento de Transportes, desenvolvido para a realização das solicitações de transportes e gerenciamento da frota de veículos da sua empresa.

## Passos para Utilizar o SG-Transportes

1 - Criar Um Banco (MySQL);
2 - Importar o SQL da Pasta "Banco de Dados" de nome sgtrans.sql para o banco criado no passo 1;
3 - criar a pasta SG_Transporte dentro do servidor apache de sua preferencia;
4 - Colocar os arquivos da pasta SG-Transportes;
5 - Com seu Editor PHP alterar o arquivo config.php da pasta C:\SG-Transportes\application\config, na linha 17 $config['base_url']	= "COLOCAAR O CAMINHO PARA O SISTEMA SE FOR LOCAL LOCALHOST/SG-TRANSPORTES";
6 - Com seu editor de PHP alterar o arquivo database.php da pasta C:\SG-Transportes\application\config, na linha 51 $db['default']['hostname'] = 'localhost'; informar o local do banco de dados;
7 - Com seu editor de PHP alterar o arquivo database.php da pasta C:\SG-Transportes\application\config, na linha 52 $db['default']['username'] = 'root'; informar o usuario  do banco de dados;
8 - Com seu editor de PHP alterar o arquivo database.php da pasta C:\SG-Transportes\application\config, na linha 53 $db['default']['password'] = ''; informar a senha do usuario do banco de dados;
9 - Com seu editor de PHP alterar o arquivo database.php da pasta C:\SG-Transportes\application\config, na linha 54 $db['default']['database'] = 'sgtransportes'; informar o nome do banco de dados criado no Passo 1;

Usuario inicial
Administrador
Senha
123

OBS: dentro da pasta "Banco de Dados" temos 2 .sql - Marca e modelo caso queira utilizar;
