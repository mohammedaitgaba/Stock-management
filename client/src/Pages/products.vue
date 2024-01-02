<script setup>
import HomeLayout from "../components/HomeLayout.vue";
import axios from "axios";
import {onMounted, ref} from "vue";

onMounted(()=>{
  getAllProducts()
})
const products = ref(null)
const displayedForm = ref(false)
const error = ref('')
const getAllProducts = async ()=>{
   await axios.get('http://127.0.0.1:8000/api/products')
       .then(res=>{
         products.value = res.data?.products
         console.log(res.data)
       }).catch(e=>{
         console.log(e)
       })
}
function getFirst30Characters(text) {
  return text.substring(0, 30);
}
const getCurrentDate = () => {
  const today = new Date();
  const year = today.getFullYear();
  const month = String(today.getMonth() + 1).padStart(2, '0');
  const day = String(today.getDate()).padStart(2, '0');
  return `${year}-${month}-${day}`;
};

const formData = ref({
  product_id:null,
  quantity:0,
  weight:0,
  expiring_date:getCurrentDate()
})


const submit = async ()=>{
  await axios.put(`http://127.0.0.1:8000/api/products/${formData.value.product_id}`,formData.value)
      .then(res=>{
        if (res.data.message === 'updated'){
          getAllProducts()
          displayedForm.value = false
        }else {
          error.value =  res.data.message
        }
      }).catch(e=>{
        console.log(e)
        error.value = 'an error happend please verifie your data'
      })
}
</script>

<template>
  <HomeLayout>
    <div class="px-4 sm:px-6 lg:px-8">
      <div class="sm:flex sm:items-center min-w-full" v-if="!displayedForm">
        <div class="sm:flex-auto">
          <h1 class="text-base font-semibold leading-6 text-gray-900">Products</h1>
          <p class="mt-2 text-sm text-gray-700">A list of all products in stock</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
          <button type="button" @click="displayedForm = !displayedForm" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            Add Product
          </button>
        </div>
      </div>
      <section v-if="displayedForm">
        <form @submit.prevent="submit" class="bg-white p-5 rounded-xl flex flex-col justify-center gap-3 w-96">
          <h2 class="text-center text-xl">Add product</h2>
          <div>
            <label for="Product" class="block text-sm font-medium leading-6 text-gray-900">Product</label>
            <select id="product"  name="product" required  v-model="formData.product_id" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
              <option v-for="product in products" :value="product.id">{{ product.name}}</option>
            </select>
          </div>
          <div>
            <label for="quantity" class="block text-sm font-medium leading-6 text-gray-900">Quantity</label>
            <div class="mt-2">
              <input
                  type="number"
                  name="quantity"
                  v-model="formData.quantity"
                  min="0"
                  class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                  required
              />
            </div>
          </div>
          <div>
            <label for="weight" class="block text-sm font-medium leading-6 text-gray-900">Weight</label>
            <div class="mt-2">
              <input
                  type="number"
                  name="weight"
                  v-model="formData.weight"
                  min="0"
                  class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                  required
              />
            </div>
          </div>
          <div>
            <label for="Expiringdate" class="block text-sm font-medium leading-6 text-gray-900">Expiring date</label>
            <div class="mt-2">
              <input
                  type="date"
                  name="date"
                  :min="getCurrentDate()"
                  v-model="formData.expiring_date"
                  class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                  required
              />
            </div>
          </div>
          <span class="text-red-600 text-center" v-if="error">{{error}}</span>
          <button
              type="submit"
              class="mt-3 block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"          >
              Submit
          </button>
        </form>
      </section>
      <section  class="mt-8 flow-root bg-white p-3 rounded-xl" v-else>
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <table class="min-w-full divide-y divide-gray-300">
              <thead>
              <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Name</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Description</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Quantity</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Weight</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Expiring date</th>
              </tr>
              </thead>
              <tbody class="bg-white ">
              <tr v-for="product in products" :key="product.id" class="even:bg-gray-50 ">
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-3">{{ product.name }}</td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ getFirst30Characters(product.description)+'...'}}</td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ product.quantity }}</td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ product.weight }}</td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ product.expiring_date }}</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </div>
  </HomeLayout>
</template>



<style scoped>

</style>