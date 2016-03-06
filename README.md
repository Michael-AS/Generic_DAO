# Generic_DAO

Com o Generic DAO é possível efetuar operações de banco de daddos (Baseados em SQL) sem escrever querys.

- O objeto deve possuir o mesmo nome e estrutura da tabela em que ele será armazenado.
- Tanto o objeto quanto a tabela devem possuir um campo "id" que representara a chave primária do objeto.  

Exemplo de consulta de um objeto do tipo Usuario

    $dao = new BasicDao();
    $usuario = $dao->selectOne("usuario", 3); //Retorna o usuário de id 3
    

Exemplo de consulta de varios objetos do tipo Usuario

    $dao = new BasicDao();
    $criterios = array ("nome" => "Ana");
    $usuario = $dao->select("usuario", $criterios); //Retorna um array de Usuarios contendo todos os usuários onde o nome contenha a palavra "Ana"

Exemplo de consulta de todos os usuários

    $dao = new BasicDao();
    $criterios = array ("nome" => "Ana");
    $usuario = $dao->selectAll("usuario"); //Retorna um array de Usuarios contendo todos os usuários cadastrados.

Exemplo de inserção de usuários

    $usuario = new Usuario();
    ...
    $dao = new BasicDao();
    echo $dao->insert($usuario); //Retorna o id do usuário inserido

Exemplo de atualização de usuários

    $usuario = new Usuario();
    ...
    $dao = new BasicDao();
    echo $dao->update($usuario);

Exemplo de remoção de usuários

    $usuario = new Usuario();
    ...
    $dao = new BasicDao();
    echo $dao->delete($usuario);
