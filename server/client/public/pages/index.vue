<script setup>
import { ref, onMounted } from 'vue';
import useAxios from '@/composables/useAxios';

const products = ref([]);
const cart = ref([]);
const { getAll } = useAxios();

onMounted(async () => {
  try {
    const response = await getAll('product');
    products.value = response.data;
  } catch (error) {
    console.error('Error fetching products:', error);
  }
});
// Add product to the cart
const addToCart = (product) => {
  const cartItem = cart.value.find(item => item.code === product.code);
  if (cartItem) {
    cartItem.quantity += 1; // Increment quantity if product is already in the cart
  } else {
    cart.value.push({ ...product, quantity: 1 }); // Add new product to cart
  }
};

// Calculate total price including delivery and offers
const calculateTotalPrice = () => {
  let total = 0;
  let redWidgetCount = 0;

  // Calculate product totals and count Red Widgets
  cart.value.forEach(item => {
    if (item.code === 'R01') {
      redWidgetCount += item.quantity;
    } else {
      total += item.price * item.quantity;
    }
  });

  // Apply "Buy One Red Widget, Get the Second Half Price" offer
  if (redWidgetCount > 0) {
    const fullPriceRedWidgets = Math.floor(redWidgetCount / 2) + (redWidgetCount % 2);
    const halfPriceRedWidgets = Math.floor(redWidgetCount / 2);
    total += fullPriceRedWidgets * 32.95 + halfPriceRedWidgets * (32.95 / 2);
  }

  // Apply delivery costs based on total price
  if (total < 50) {
    total += 4.95;
  } else if (total < 90) {
    total += 2.95;
  }

  return total.toFixed(2);
};
</script>

<template>
  <div class="jumbotron">
    <div class="jumbotron_background"></div>
    <div class="container-fluid">
      <h1 class="offset-md-2">Acme Widget Co</h1>
      <p class="offset-md-2">Acme Widget Co are the leading provider of made-up widgets and they’ve contracted you to create a proof of concept for their new sales system.</p>

      <!-- Delivery Information -->
      <div class="row offset-md-2">
        <div class="col-md-8">
          <h3>Delivery Costs</h3>
          <ul>
            <li>Orders under $50: $4.95 delivery fee</li>
            <li>Orders under $90: $2.95 delivery fee</li>
            <li>Orders of $90 or more: Free delivery</li>
          </ul>
        </div>
      </div>

      <!-- Special Offers -->
      <div class="row offset-md-2">
        <div class="col-md-8">
          <h3>Special Offers</h3>
          <p>Buy one Red Widget (R01), get the second at half price.</p>
        </div>
      </div>

      <!-- Products Table -->
      <div class="row offset-md-2">
        <div class="col-md-8">
          <h3>Products</h3>
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Product</th>
              <th>Code</th>
              <th>Price</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="product in products" :key="product.code">
              <td>{{ product.name }}</td>
              <td>{{ product.code }}</td>
              <td>${{ product.price }}</td>
              <td>
                <button @click="addToCart(product)">Add to Cart</button>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Cart Display -->
      <div class="row offset-md-2">
        <div class="col-md-8">
          <h3>Cart</h3>
          <table class="table table-striped" v-if="cart.length">
            <thead>
            <tr>
              <th>Product</th>
              <th>Code</th>
              <th>Quantity</th>
              <th>Price</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in cart" :key="item.code">
              <td>{{ item.name }}</td>
              <td>{{ item.code }}</td>
              <td>{{ item.quantity }}</td>
              <td>${{ (item.price * item.quantity).toFixed(2) }}</td>
            </tr>
            </tbody>
          </table>

          <div v-if="cart.length">
            <h4>Total Price: ${{ calculateTotalPrice() }}</h4>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<style>
.jumbotron_background {
  background-color: #f8f9fa;
  height: 150px;
}
</style>