<script setup>
import HomeLayout from "../components/HomeLayout.vue";
import axios from "axios";
import {onMounted, ref} from "vue";
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'

const recieps = ref(null)
const products = ref(null)
const open = ref(false)
const activeReciepe = ref(null)
const selectedProduct = ref()
const preperedItem = ref()
const selectedItems = ref([])
const selectedQuantity =ref(1)
const inValidation = ref(false)
onMounted(()=>{
  getAllRecieps()
})
const getAllProducts = async ()=>{
  await axios.get('http://127.0.0.1:8000/api/products')
      .then(res=>{
        products.value = res.data?.products
        console.log(res.data)
      }).catch(e=>{
        console.log(e)
      })
}

const getAllRecieps = async ()=>{
  await axios.get('http://127.0.0.1:8000/api/recipes')
      .then(res=>{
        recieps.value = res.data?.recieps
        console.log(res.data)
      }).catch(e=>{
        console.log(e)
      })
}

const setItem = (item)=>{
  activeReciepe.value = item
  open.value = true
  getAllProducts()
}
const prepareItem = () => {
    inValidation.value =true
    preperedItem.value = selectedProduct.value
};
const validateProduct = ()=>{
  selectedItems.value.push({
    product_id:preperedItem.value.id,
    name:preperedItem.value.name,
    quantity:selectedQuantity.value
  })
  selectedQuantity.value = 1
  selectedProduct.value = null
  preperedItem.value = null
  inValidation.value = false
}

const submit = async ()=>{
  await axios.post(`http://127.0.0.1:8000/api/recipes/${activeReciepe.value.id}`, {products_info:selectedItems.value})
      .then(res=>{
        open.value = false
        selectedItems.value = null
        getAllRecieps()
      }).catch(e=>{
        console.log(e)
      })

}
</script>

<template>
  <HomeLayout>
    <main class="grid grid-cols-3 w-full gap-5">
        <section class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6 rounded-xl max-h-fit" v-for="reciepe in recieps">
          <div class="-ml-4 -mt-2 flex flex-wrap items-center justify-between sm:flex-nowrap">
            <div class="ml-4 mt-2 ">
              <h3 class="text-base font-semibold leading-6 text-gray-900">{{ reciepe.name }}</h3>
            </div>
            <div v-if="!reciepe.products.length" class="">
              <button
                  type="button"
                  class="rounded-full bg-white px-3 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                  @click="setItem(reciepe)"
              >
                Validate
              </button>
            </div>
          </div>
          <span class="text-gray-600 text-xs bg-blue-100 px-2 py-1 rounded-xl" v-if="reciepe.products.length">
            products required
          </span>
          <div v-for="product in reciepe.products">
            <div class="py-2 border-b flex justify-between">
              <span class="text-gray-600">
                {{product.name}}
              </span>
              <span>
                {{product?.quantityInReciep}}
              </span>
            </div>
          </div>
        </section>
    </main>
  </HomeLayout>

  <TransitionRoot as="template" :show="open">
    <Dialog as="div" class="relative z-10" @close="open = false">
      <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
      </TransitionChild>

      <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <DialogPanel class="min-w-[50rem] relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
              <div>
                <div class="mx-auto flex font-semibold text-xl items-center justify-center">
                  Validate Reciepe
                </div>
                <section class="py-3">
                  <div>
                    <div>
                      <label for="Product" class="block text-sm font-medium leading-6 text-gray-900">Select Product</label>
                      <select v-model="selectedProduct" @change="prepareItem" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <option v-for="product in products" :key="product.id" :value="product">{{ product.name }}</option>
                      </select>
                    </div>



                    <div class="border-b text-xs grid grid-cols-2 gap-3 justify-between items-center text-gray-600" v-if="selectedItems?.length">
                      <span class="py-2">Product Name</span>
                      <span class="text-center">Quantity selected</span>
                    </div>
                    <!-- Display the selected items -->

                    <div class="grid grid-cols-2 w-full items-center justify-center gap-3 py-3" v-for="item in selectedItems" :key="item.id">
                      <span>{{ item.name }}</span>
                      <span class="text-center bg-gray-300">{{ item.quantity}}</span>
                    </div>
<!--                    validate the selected item -->
                    <div class=" w-full items-center justify-center py-3 border my-2 rounded-xl" v-if="preperedItem">
                      <div class="px-2 grid grid-cols-4 gap-3">
                        <div class="flex flex-col justify-between">
                          <label class="text-xs"> product name </label>
                          <span>{{ preperedItem?.name }}</span>
                        </div>
                        <div class="flex flex-col justify-between">
                          <label class="text-xs"> In stock</label>
                          <span class="text-center bg-gray-300">{{ preperedItem?.quantity ?? 'Out of stock' }}</span>
                        </div>
                        <div class="flex flex-col justify-between">
                          <label class="text-xs"> Selected quantity</label>
                          <input type="number" class="border px-4" min="1" :max="preperedItem?.quantity" v-model="selectedQuantity">
                        </div>
                        <button @click="validateProduct" class=" rounded-xl" :disabled="!preperedItem?.quantity" :class="!preperedItem?.quantity ?'bg-gray-300':'bg-green-200'">Validate</button>
                      </div>
                    </div>

                  </div>
                  </section>
              <div class="mt-5 sm:mt-6 flex items-center justify-end gap-3">
                <button type="button"
                        class="rounded-full bg-white px-6 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                  @click="submit"
                >
                  Submit
                </button>
                <button
                    @click="open = false"
                    class="rounded-full bg-gray-300 px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                >
                  Cancel
                </button>
              </div>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<style scoped>

</style>