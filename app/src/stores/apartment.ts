import {ref} from 'vue'
import {defineStore} from 'pinia'
import {Apartment} from "@/models/apartment";

export const useApartmentStore = defineStore('apartment', () => {
    const apartments = ref<Apartment[]>([])
    const apartment = ref<Apartment | null>(null)
    const violations = ref([])

    async function getAll() {
        await fetch("http://localhost/api/apartments")
            .then(res => {
                return res.json()
            })
            .then(data => {
                apartments.value = data
            })
    }

    async function get(id: number) {
        await fetch("http://localhost/api/apartments/" + id)
            .then(res => {
                return res.json()
            })
            .then((data: Apartment) => {
                apartment.value = data
            })
    }

    async function create(data: Apartment) {
        await fetch(
            "http://localhost/api/apartments",
            {
                method: "POST",
                body: JSON.stringify(data),
                headers: {
                    "Content-Type": "application/json"
                }
            }
        )
            .then(res => {
                if (res.status === 422) {
                    return res.json()
                }

                return res.json()
            })
            .then(data => {
            })
            .catch((errors) => {
                console.log(errors)
            })
    }

    async function update(data: Apartment) {
        let hasViolations = false
        await fetch(
            "http://localhost/api/apartments/" + data.id
            ,
            {
                method: "PUT",
                body: JSON.stringify(data),
                headers: {
                    "content-type": "application/json"
                }
            }
        )
            .then((response) => {
                if (response.status === 422) {
                    hasViolations = true
                    return response.json()
                }

                return response.json()
            })
            .then((data) => {
                if (hasViolations) {
                    violations.value = data
                }
            })
            /** error in the below case would contain { name: 'Database', message: 'Failed to connect to database', status: 500 } */
            .catch((error) => {
                console.log(error)
            });
    }

    return {apartments, apartment, getAll, get, create, update}
})
