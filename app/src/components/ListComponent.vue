<script setup lang="ts">

import {computed, onMounted, ref} from "vue";
import FormComponent from "@/components/FormComponent.vue";
import {useApartmentStore} from "@/stores/apartment";
import {PriceCategory} from "@/enums/priceCategory";

const apartmentStore = useApartmentStore()

const id = ref<Number>(0)

const suites = computed(() => apartmentStore.apartments)

const deleteSuite = (id: number) => {
  suites.value.splice(suites.value.findIndex((suite) => {
    return suite.id === id
  }), 1)
}

const createDialog = ref<Boolean>(false)
const updateDialog = ref<Boolean>(false)

const edit = (idSuite: number) => {
  id.value = idSuite
  updateDialog.value = true
}

const loading = ref(false)

const closeDialog = async () => {
  createDialog.value = false
  updateDialog.value = false

  loading.value = true
  await apartmentStore.getAll()
  loading.value = false
}


onMounted(async () => {
  loading.value = true
  await apartmentStore.getAll()
  loading.value = false
})
</script>

<template>
  <Button label="Ajouter un logement" @click="createDialog = true"/>

  <Dialog v-model:visible="createDialog" modal header="Logement" :style="{ width: '25rem' }">
    <FormComponent @updated="closeDialog"/>
    <Button type="button" label="Annuler" severity="secondary" @click="createDialog = false"></Button>
  </Dialog>
  <Dialog v-model:visible="updateDialog" modal header="Logement" :style="{ width: '25rem' }">
    <FormComponent :id="id" @updated="closeDialog"/>
    <Button type="button" label="Annuler" severity="secondary" @click="updateDialog = false"></Button>
  </Dialog>
  <DataTable :loading="loading" class="w-full" :value="suites" tableStyle="min-width: 50rem">
    <Column field="nbRooms" header="Number of rooms"></Column>
    <Column field="surface" header="Surface"></Column>
    <Column field="nbWindows" header="Number of windows"></Column>
    <Column field="price" header="Price">
      <template #body="slotProps">
        {{slotProps.data.price }} €
      </template>
    </Column>
    <Column field="year" header="Year"></Column>
    <Column field="balcony" header="Balcony">
      <template #body="slotProps">
        <Badge :value="slotProps.data.balcony ? 'Yes' : 'No'" :severity="slotProps.data.balcony ? 'primary' : 'danger'"></Badge>
      </template>
    </Column>
    <Column field="garage" header="Garage">
      <template #body="slotProps">
        <Badge :value="slotProps.data.garage ? 'Yes' : 'No'" :severity="slotProps.data.garage ? 'primary' : 'danger'"></Badge>
      </template>
    </Column>
    <Column field="note" header="Note">
      <template #body="slotProps">
        <Rating :modelValue="slotProps.data.note" readonly />
      </template>
    </Column>
    <Column field="priceCategory" header="Price Category">
      <template #body="slotProps">
        <Badge :value="slotProps.data.priceCategory.toUpperCase()" :severity="PriceCategory.getSeverity(slotProps.data.priceCategory)"></Badge>
      </template>
    </Column>
    <Column field="city" header="City">
      <template #body="slotProps">
        {{ slotProps.data.city.toUpperCase() }}
      </template>
    </Column>
    <Column>
      <template #body="slotProps" style="min-width: 12rem">
        <Button type="button" icon="pi pi-pencil" severity="primary" @click="edit(parseInt(slotProps.data.id))"/>
<!--        <Button type="button" icon="pi pi-trash" severity="danger" @click="deleteSuite(slotProps.data.id)"/>-->
      </template>
    </Column>
  </DataTable>

</template>

<style scoped>

</style>