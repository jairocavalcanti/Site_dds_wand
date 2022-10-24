<?php

/**
 * Classe ContratoController
 * @author Felype Rangel <felype.sales@outlook.com>
 * @version 1.0
 * 
 */

namespace App\Controllers;

use \App\Entities\Produto as Produto;
use \App\Models\ProdutoModel as ProdutoModel;

class ProdutoController extends Controller
{
   private Produto $entity;
   private ProdutoModel $model;

   public function __construct()
   {
      parent::__construct();
      $this->model = new \App\Models\ProdutoModel();
   }

   /**
    * Obter todos os registros da base de dados
    * 
    * @return json    
    */
   public function getAll()
   {
      $produtos = $this->model->getAll();
      if ($produtos) {
         return json_encode([
            'success' => true,
            'data' => $produtos,
            'message' => 'dados obtidos com sucesso.'
         ]);
      }

      return ([
         'success' => false,
         'data' => [],
         'message' => 'consulta não retornou dados'
      ]);
   }

   public function getById($id)
   {
      $produto = $this->model->getById($id);
      return json_encode([
         'success' => $this->success,
         'data' => $produto,
         'message' => 'registro obtido com sucesso'
      ]);
   }

   //Incluir um novo registro na base de dados
   public function add(Produto $entity)
   {

      $success = $this->model->add($entity);

      //die($success);

      //die(var_dump($success));

      if ($success) {
         return json_encode([
            'success' => true,
            'data' => [],
            'message' => 'Registro incluido com sucesso'
         ]);
      }

      return json_encode([
         'success' => false,
         'data' => [],
         'message' => 'Registro não foi incluido'
      ]);
   }

   //Atualiza o contato na base de dados
   public function update(Produto $produto)
   {
      if ($this->model->update($produto)) {
         $this->success = true;
         $this->data = [];
         $this->msg = 'Registro atualizado com sucesso.';
      }

      return json_encode([
         'success' => $this->success,
         'data' => $this->data,
         'message' => $this->msg
      ]);
   }

   //Excluir um novo registro na base de dados
   public function delete($id)
   {
      if ($this->model->delete($id)) {
         $this->success = true;
         $this->data = [];
         $this->msg = 'Registro excluído com sucesso.';
      }

      return json_encode([
         'success' => $this->success,
         'data' => $this->data,
         'message' => $this->msg
      ]);
   }
}
