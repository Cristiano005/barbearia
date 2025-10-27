<template>
    <div class="modal fade" ref="serviceAddModalRef" id="serviceAddModal" tabindex="-1" aria-labelledby="serviceAddModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="serviceAddModalLabel">Add Service</h1>
                    <button type="button" class="btn-close" aria-label="Close" @click="bootstrapModalInstance.hide"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="serviceName" class="form-label">Name*</label>
                            <input type="text" class="form-control" name="serviceName" id="serviceName"
                                placeholder="Service name" v-model="serviceName">
                            <div ref="timeMessageContainer"></div>
                        </div>
                        <div class="mb-3">
                            <label for="servicePrice" class="form-label">Price*</label>
                            <BRLInput placeholder="R$ 0,00" v-model="servicePrice" :options="BRL_INPUT_OPTIONS" />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="bootstrapModalInstance.hide">Close</button>
                    <button type="button" class="btn btn-success" @click="addService()">Add Service</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">

import { onMounted, ref, useTemplateRef } from "vue";

import { Modal } from "bootstrap";
import Swal from "sweetalert2";

import { axiosInstance } from "@/helpers/helper";
import { BRL_INPUT_OPTIONS } from "@/utils/currencySettings";

import BRLInput from "../BRLInput.vue";

const emit = defineEmits(["serviceAdded"]);


const serviceName = ref<string>("");
const servicePrice = ref<number | null>(null);

const modalElement = useTemplateRef("serviceAddModalRef");
const bootstrapModalInstance = ref<Modal | null>(null);

async function addService() {

    if (!serviceName.value || !servicePrice.value) {
        Swal.fire({
            icon: "error",
            title: "Please, fill all fields!",
        });
        return;
    }

    try {

        const { data } = await axiosInstance.post(`/api/v1/admin/services`, {
            name: serviceName.value,
            price: servicePrice.value,
        });

        if (data.success) {

            emit("serviceAdded");

            serviceName.value = "";
            servicePrice.value = null;

            Swal.fire({
                icon: "success",
                title: data.message,
            });
        }
    }

    catch (error) {
        console.log(error);
    }
}

onMounted(() => {
    bootstrapModalInstance.value = new Modal(modalElement.value, {});
});

</script>