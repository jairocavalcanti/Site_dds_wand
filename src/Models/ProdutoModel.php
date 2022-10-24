<?php
/**
 * Model produto
 * 
 * @author Felype Rangel <felype.sales@outlook.com>
 * @version 1.0
 * 
 */

 namespace App\Models;

 use \App\Persistence\Conexao as Conexao;

 class ProdutoModel  {
    
    protected  $con;
    protected \App\Entities\Produto $entity;
    
    public function __construct() {
        $this->con = Conexao::getInstance();
    }

    public function getAll(){
        $sql = 'SELECT * FROM produtos ';
        $query = $this->con->query($sql, \PDO::FETCH_OBJ);

        $data = [];
        foreach( $query->fetchAll() as $row ) { 
             $data[] = $row;
        }
        
        return $data;
    }


    // public function getById(){
    //     $sql = 'SELECT * FROM produtos WHERE id = ?';
    //     //$query = $this->con->query($sql, \PDO::FETCH_OBJ);
        


        
    // }

    public function add(\App\Entities\Produto $entity): bool{

        //die(var_dump($entity));

        $sql  = ' INSERT INTO produtos (nome, descricao, preco) ';
        $sql .= ' VALUES(?,?,? ) ' ;

        $stm = $this->con->prepare($sql);

       //die(var_dump($entity));
        
        //$stm->bindValue(1, $entity->getId());
        $stm->bindValue(1, $entity->getNome());
        $stm->bindValue(2, $entity->getDescricao());
        $stm->bindValue(3, $entity->getPreco());
       

        $inserted = $stm->execute();

        //die(var_dump($inserted));

        // return [
        //     'success' => $inserted,
        //     'data' => [],
        //     'message' => $inserted ? 'registro salvo com sucesso' : 'não foi possível incluir o registro'
        // ];

        
        return $inserted;
    }

    public function update(\App\Entities\Produto $entity): bool{
           //die(var_dump($entity));

           $sql  = ' UPDATE produtos                             
                            SET nome = ? , 
                            descricao = ? , 
                            preco = ? ';

           $sql .= ' WHERE id = ? ' ;
              
           $stm = $this->con->prepare($sql);
   
           $stm->bindValue(1, $entity->getNome());
           $stm->bindValue(2, $entity->getDescricao());
           $stm->bindValue(3, $entity->getPreco());
           $stm->bindValue(4, $entity->getId());
   
           $updated = $stm->execute();
   
           //die(var_dump($inserted));
   
        //    return [
        //        'success' => $updated,
        //        'data' => [],
        //        'message' => $update ? 'registro salvo com sucesso' : 'não foi possível incluir o registro'
        //    ];
   
           return $updated;
    }

    public function delete($id){
        $sql  = ' DELETE FROM produtos '; 
        $sql .= ' WHERE id = ? ' ;

        $stm = $this->con->prepare($sql);
        $stm->bindValue(1, $id);

        $deleted = $stm->execute();


         return json_encode([
               'success' => $deleted,
               'data' => [],
               'message' => $deleted ? 'registro excluído com sucesso' : 'não foi possível excluir o registro'
           ]);

        //return $updated;      
    } 

 }