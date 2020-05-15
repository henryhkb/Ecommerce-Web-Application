let products = document.querySelectorAll('.add-to-cart');



for(let i=0; i < products.length; i++){
    products[i].addEventListener('click',()=>{
        productItems();
    });
} 




function productItems(product){
    console.log("The product you clicked is", products);
    let productNumbers = localStorage.getItem('productItems');

    productNumbers = parseInt(productNumbers );

    if(productNumbers ){
        localStorage.setItem('productItems', productNumbers + 1);
        document.querySelector('.cart span').textContent = productNumbers + 1;
    }else{
        localStorage.setItem('productItems',1);
        document.querySelector('.cart span').textContent = 1;
    }

    
   
   
}
  