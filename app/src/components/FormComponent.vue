<script setup lang="ts">

import {onMounted, ref} from "vue";
import {useApartmentStore} from "@/stores/apartment";
import {Apartment} from "@/models/apartment";
import {PriceCategory} from "@/enums/priceCategory";
import {City} from "@/enums/city";

const apartmentStore = useApartmentStore()

const suite = ref<Apartment | null>(new Apartment())
const priceCategory = ref()
const priceCategories = [
  {
    label: "LOW",
    value: PriceCategory.LOW
  },
  {
    label: "NORMAL",
    value: PriceCategory.NORMAL
  },
  {
    label: "HIGH",
    value: PriceCategory.HIGH
  },
  {
    label: "SCAM",
    value: PriceCategory.SCAM
  }
]

const city = ref()
const cities = [
  {
    label: "PARIS",
    value: City.PARIS
  },
  {
    label: "LYON",
    value: City.LYON
  },
  {
    label: "MARSEILLE",
    value: City.MARSEILLE
  }
]

const props = defineProps({
  id: {
    type: Number,
    required: false
  }

})
const emits = defineEmits<{
  updated: []
}>()

const isLoading = ref(false)

onMounted(async () => {
  if (props.id) {
    isLoading.value = true
    await apartmentStore.get(props.id)
    suite.value = apartmentStore.apartment
    isLoading.value = false
  }
})

const submit = async () => {
  if (suite.value !== null && suite.value.id !== null) {
    await apartmentStore.update(suite.value)
  } else {
    await apartmentStore.create(suite.value)
  }

  emits("updated")
}

</script>

<template>
  <form v-if="!isLoading" @submit.prevent="submit">
    <div class="field">
      <label for="nbRooms">Nombre de chambre</label>
      <InputNumber show-buttons v-model.number="suite.nbRooms" inputId="nbRooms" fluid/>
    </div>
    <div class="field">
      <label for="surface">Surface</label>
      <InputNumber show-buttons v-model.number="suite.surface" inputId="surface" suffix=" m²" fluid/>

    </div>
    <div class="field">
      <label for="nbWindows">Nombre de Fenêtre</label>
      <InputNumber show-buttons v-model.number="suite.nbWindows" inputId="nbWindows" fluid/>
    </div>
    <div class="field">
      <label for="price">Price</label>
      <InputNumber show-buttons mode="currency" currency="EUR" v-model.number="suite.price" inputId="price" fluid/>
    </div>
    <div class="field">
      <label for="year">Year</label>
      <InputNumber show-buttons v-model.number="suite.year" inputId="year" fluid/>
    </div>
    <div class="field grid">
      <label for="balcony">Balcony</label>
      <div class="ml-2">
        <ToggleSwitch inputId="balcony" v-model="suite.balcony"/>
      </div>
    </div>
    <div class="field grid">
      <label for="garage">Garage</label>
      <div class="ml-2">
        <ToggleSwitch inputId="balcony" v-model="suite.garage"/>
      </div>
    </div>
    <div class="field">
      <label for="note">Note</label>
      <Rating v-model="suite.note"/>
    </div>

    <div class="field">
      <Select v-model="priceCategory" :options="priceCategories" @change="suite.priceCategory= priceCategory.value.toLowerCase()" optionLabel="label"
              placeholder="Select a Price Category"
              class="w-full"/>
    </div>

    <div class="field">
      <Select v-model="city" :options="cities" @change="suite.city= city.value.toLowerCase()
     " optionLabel="label"
              placeholder="Select a City"
              class="w-full"/>
    </div>


    <Button type="submit" label="Enregistrer"/>
  </form>

</template>

<style scoped>

</style>