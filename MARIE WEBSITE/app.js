let listProductHTML = document.querySelector(".listProduct");
let listCartHTML = document.querySelector(".listCart");
let iconCart = document.querySelector(".icon-cart");
let iconCartSpan = document.querySelector(".icon-cart span");
let body = document.querySelector("body");
let closeCart = document.querySelector(".close");
let products = [];
let cart = [];

iconCart.addEventListener("click", () => {
  body.classList.toggle("showCart");
});
closeCart.addEventListener("click", () => {
  body.classList.toggle("showCart");
});

const addDataToHTML = () => {
  listProductHTML.innerHTML = "";
  if (products.length > 0) {
    products.forEach((product) => {
      let newProduct = document.createElement("div");
      newProduct.dataset.id = product.id;
      newProduct.classList.add("item");
      newProduct.innerHTML = `<img src="${product.image}" alt="">
            <h2>${product.name}</h2>
            <div class="price">$${product.price}</div>
            <div class="quantity">Quantity remaining: ${product.quantity}</div>
            <button class="addCart">Add To Cart</button>`;
      listProductHTML.appendChild(newProduct);
    });
  }
};

listProductHTML.addEventListener("click", (event) => {
  let positionClick = event.target;
  if (positionClick.classList.contains("addCart")) {
    let id_product = positionClick.parentElement.dataset.id;
    addToCart(id_product);
  }
});

const addToCart = (product_id) => {
  let positionThisProductInCart = cart.findIndex(
    (value) => value.product_id == product_id
  );
  let positionThisProductInProducts = products.findIndex(
    (value) => value.id == product_id
  );

  if (products[positionThisProductInProducts].quantity > 0) {
    products[positionThisProductInProducts].quantity -= 1;

    if (cart.length <= 0) {
      cart = [
        {
          product_id: product_id,
          quantity: 1,
        },
      ];
    } else if (positionThisProductInCart < 0) {
      cart.push({
        product_id: product_id,
        quantity: 1,
      });
    } else {
      cart[positionThisProductInCart].quantity += 1;
    }

    addDataToHTML();
    addCartToHTML();
    addCartToMemory();
  } else {
    console.log("Not enough product in stock");
  }
};

const addCartToHTML = () => {
    listCartHTML.innerHTML = '';
    let totalQuantity = 0;
    let totalPrice = 0; // Add this line
    if(cart.length > 0){
        cart.forEach(item => {
            totalQuantity += item.quantity;
            let newItem = document.createElement('div');
            newItem.classList.add('item');
            newItem.dataset.id = item.product_id;

            let positionProduct = products.findIndex((value) => value.id == item.product_id);
            let info = products[positionProduct];
            
            let itemTotalPrice = info.price * item.quantity; // Calculate the total price for this item
            totalPrice += itemTotalPrice; // Add the total price for this item to the total price for all items
            
            newItem.innerHTML =
            `<div class="image">
                <img src="${info.image}">
             </div>
             <div class="name">
                ${info.name}
             </div>
             <div class="totalPrice">$${itemTotalPrice}</div> <!-- Display the total price for this item -->
             <div class="quantity">
                <span class="minus"><</span>
                <span>${item.quantity}</span>
                <span class="plus">></span>
             </div>`;
             
             listCartHTML.appendChild(newItem);
        })
    }
    iconCartSpan.innerText = totalQuantity;
    
    // Add these lines to display the total price of all items in the cart
    let totalPriceElement = document.createElement('div');
    totalPriceElement.classList.add('totalPrice');
    totalPriceElement.innerText = 'Total price: ' + totalPrice;
    listCartHTML.appendChild(totalPriceElement);

    // Store total price in local storage
    localStorage.setItem('totalPrice', totalPrice);
}


listCartHTML.addEventListener("click", (event) => {
  let positionClick = event.target;
  if (
    positionClick.classList.contains("minus") ||
    positionClick.classList.contains("plus")
  ) {
    let product_id = positionClick.parentElement.parentElement.dataset.id;
    let type = "minus";
    if (positionClick.classList.contains("plus")) {
      type = "plus";
    }
    changeQuantityCart(product_id, type);
  }
});

const changeQuantityCart = (product_id, type) => {
  let positionItemInCart = cart.findIndex(
    (value) => value.product_id == product_id
  );
  let positionThisProductInProducts = products.findIndex(
    (value) => value.id == product_id
  );

  if (positionItemInCart >= 0) {
    switch (type) {
      case "plus":
        if (products[positionThisProductInProducts].quantity > 0) {
          products[positionThisProductInProducts].quantity -= 1;
          cart[positionItemInCart].quantity += 1;
        } else {
          console.log("Not enough product in stock");
        }
        break;

      default:
        let changeQuantity = cart[positionItemInCart].quantity - 1;
        if (changeQuantity > 0) {
          products[positionThisProductInProducts].quantity += 1;
          cart[positionItemInCart].quantity -= 1;
        } else {
          products[positionThisProductInProducts].quantity += 1;
          cart.splice(positionItemInCart, 1);
        }
        break;
    }
  }
  addDataToHTML();
  addCartToHTML();
  addCartToMemory();
};

const addCartToMemory = () => {
  localStorage.setItem("cart", JSON.stringify(cart));
};

const initApp = () => {
  fetch("products.json")
    .then((response) => response.json())
    .then((data) => {
      products = data;
      addDataToHTML();

      if (localStorage.getItem("cart")) {
        cart = JSON.parse(localStorage.getItem("cart"));
        addCartToHTML();
      }
    });
};


// Rest of your JavaScript code

function updateOrders() {
  let ordersHTML = '';
  for (let item of cart) {
      ordersHTML += `<div class="order-item">${item.name} - ${item.quantity}</div>`;
  }
  document.querySelector('.orders').innerHTML = ordersHTML;
}

// Rest of your JavaScript code

fetch('/getPaymentDetails')
  .then(response => response.json())
  .then(data => {
      let paymentsHTML = '';
      for (let payment of data) {
          paymentsHTML += `<div class="payment-detail">${payment.user_name} - ${payment.finalAmount}</div>`;
      }
      document.querySelector('.payments').innerHTML = paymentsHTML;
  });

// Rest of your JavaScript code

initApp();





