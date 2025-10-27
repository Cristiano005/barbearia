<template>
    <div class="modal fade" ref="serviceEditModalRef" id="serviceEditModal" tabindex="-1"
        aria-labelledby="serviceEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="serviceEditModalLabel">Edit Service</h1>
                    <button type="button" class="btn-close" aria-label="Close"
                        @click="bootstrapModalInstance.hide"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" name="serviceId" id="serviceId">
                        <div class="mb-3">
                            <label for="serviceName" class="form-label">Name*</label>
                            <input type="text" class="form-control" name="serviceName" id="serviceName"
                                placeholder="Service name" v-model="serviceName">
                            <div ref="timeMessageContainer"></div>
                        </div>
                        <div class="mb-3">
                            <label for="servicePrice" class="form-label">Price*</label>
                            <BRLInput placeholder="R$ 0,00" v-model="servicePrice" :options="BRL_INPUT_OPTIONS" />
                            <div ref="timeMessageContainer"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="bootstrapModalInstance.hide">Close</button>
                    <button type="button" class="btn btn-warning" @click="updateService">Update
                        Service</button>
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
import type { ServiceInterface } from "@/helpers/types";
import { BRL_INPUT_OPTIONS } from "@/utils/currencySettings";

import BRLInput from "../BRLInput.vue";

const emit = defineEmits(["serviceUpdated"]);
defineExpose({ openAndSetData });

const modalElement = useTemplateRef("serviceEditModalRef");
const bootstrapModalInstance = ref<Modal | null>(null);

const serviceId = ref<number | null>(null);
const serviceName = ref<string>("");
const servicePrice = ref<number | null>(null);

function openAndSetData(service: ServiceInterface) {
    serviceId.value = service.id;
    if (bootstrapModalInstance.value) bootstrapModalInstance.value.show();
}

async function updateService() {

    if (!serviceName.value || !servicePrice.value) {
        Swal.fire({
            icon: "error",
            title: "Please, fill all fields!",
        });
        return;
    }

    try {

        const { data } = await axiosInstance.put(`/api/v1/admin/services/${serviceId.value}`, {
            name: serviceName.value,
            price: servicePrice.value,
        });

        if (data.success) {

            emit("serviceUpdated");

            serviceId.value = null;
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