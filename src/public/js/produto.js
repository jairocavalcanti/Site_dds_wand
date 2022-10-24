/**
 * 
 * Carrega os dados que já estão visualizados na linha da tabela
 * e popula os dados dos elementos inputs do formulário
 * evitando assim que nova requisição seja enviada para o servidor
 * @author Felype Rangel <felype.sales@outlook.com>
 * @version 1.0
 * 
 */

 const popularFormProduto = (elem) => {
    // pega os dados do elemento pai
    var ct = elem.parentNode.parentNode
  
    // popula os inputs do formulário
    document.getElementById("form-produto").id.value = ct.getAttribute('data-id')
    document.getElementById("form-produto").nome.value = ct.getAttribute('data-nome')
    document.getElementById("form-produto").descricao.value = ct.getAttribute('data-descricao')
    document.getElementById("form-produto").preco.value = ct.getAttribute('data-preco')
    
  }
  
  const obterProdutos = () => {
      
      const tbProdutos = document.getElementById('tb-produtos')
      
      let html = ""
  
      fetch('produto.php')
      .then (resp => resp.json())
      .then ( resp => {
          //const json = JSON.parse(resp)
          console.log(resp.data)
  
          resp.data.forEach( (e) => {
              console.log(e)
              html += `<tr data-id="${e.id}" data-nome="${e.nome}" 
                           data-descricao="${e.descricao}" data-preco="${e.preco}">
  
                          <td>${e.id}</td>
                          <td>${e.nome}</td>
                          <td>${e.descricao}</td>
                          <td>${e.preco}</td>
                          <td>
                             <button type="button" onclick="popularFormProduto(this);"   class="btn btn-info btn-sm">
                                  <i class="fa fa-edit"></i>
                              </button>
                             <button type="button" onclick="excluirProduto(${e.id})" class="btn btn-danger btn-sm">
                                  <i class="fa fa-trash"></i>
                              </button>
                          </td>
                      </tr>`           
          })
      })
      .finally( ()  =>  tbProdutos.innerHTML = html )
  }
  
  
  const salvarProduto = (e) => {
  
      const id =       document.getElementById('id').value;
      const nome =     document.getElementById('nome').value;
      const descricao =  document.getElementById('descricao').value;
      const preco =    document.getElementById('preco').value;
     

      let formProduto = new FormData();

      formProduto.append('id', id);
      formProduto.append('nome', nome);
      formProduto.append('descricao', descricao);
      formProduto.append('preco', preco);
      
      
      //console.log(formContato.toString())
      if ( id > 0 ){
          fetch('produto.php', {
                                 mode: 'cors',
                                 method: 'PUT', 
                                 body: new URLSearchParams(formProduto), 
                                 headers: { 'Content-Type': 'application/x-www-form-urlencoded'} 
          })
           .then(resp => resp.json())
           .then(resp => { console.log(resp); obterProdutos() })
           .catch(err => console.log(err))
                              
          console.log('atualizando...');
  
      } else {
         fetch('produto.php', {
              mode: 'cors',
              method: 'POST', 
              body: new URLSearchParams(formProduto), 
              headers: { 'Content-Type': 'application/x-www-form-urlencoded'} 
           })
           .then(resp => resp.json())
           .then(resp => {console.log(resp); obterProdutos()})
           .catch(err => console.log(err))
  
           
           console.log('incluindo novo...');
          }

          return false;
      }
  
  const excluirProduto = (id) => {
      
      let formProduto = new FormData();
      formProduto.append('id', id);
      
      let salvar = undefined
      
      fetch(`produto.php?id=${id}`, {
          mode: 'cors',
          method: 'DELETE', 
          //body: new URLSearchParams(formContato), 
          //headers: { 'Content-Type': 'application/x-www-form-urlencoded'} 
       })
       .then(resp => resp.json())
       .then(resp => {console.log(resp); obterProdutos()})
       .catch(err => console.log(err))
  
       
       console.log('excluindo o registro...')
  }
      
      