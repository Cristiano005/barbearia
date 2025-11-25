<template>
    <div class="modal fade" ref="serviceAddModalRef" id="serviceAddModal" tabindex="-1"
        aria-labelledby="serviceAddModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="serviceAddModalLabel">Add Service</h1>
                    <button type="button" class="btn-close" aria-label="Close"
                        @click="bootstrapModalInstance.hide"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3 has-validation">
                            <label for="serviceName" class="form-label">Name*</label>
                            <input type="text" :class="['form-control', errors.serviceName ? 'is-invalid' : '']"
                                name="serviceName" id="serviceName" placeholder="Service name" v-bind="serviceNameAttrs"
                                v-model="serviceName">
                            <div :class="errors.serviceName ? 'invalid-feedback' : ''">
                                {{ errors.serviceName }}
                            </div>
                        </div>
                        <div class="mb-3 has-validation">
                            <label for="servicePrice" class="form-label">Price*</label>
                            <BRLInput :class="['form-control', errors.servicePrice ? 'is-invalid' : '']"
                                placeholder="R$ 0,00" v-bind="servicePriceAttrs" v-model="servicePrice"
                                :options="BRL_INPUT_OPTIONS" />
                            <div :class="errors.servicePrice ? 'invalid-feedback' : ''">
                                {{ errors.servicePrice }}
                            </div>
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

import { useForm } from "vee-validate";
import { toTypedSchema } from "@vee-validate/yup";
import * as yup from "yup";
import { Modal } from "bootstrap";
import Swal from "sweetalert2";

import { axiosInstance } from "@/helpers/helper";
import { BRL_INPUT_OPTIONS } from "@/utils/currencySettings";

import BRLInput from "../BRLInput.vue";

const schema = toTypedSchema(
    yup.object({
        serviceName: yup.string().required("name is a required field").min(2, "name must be at least 2 characters"),
        servicePrice: yup.number().required("price is a required field").positive().max(200, "price cannot be more than 200"),
    }),
);

const { defineField, resetForm, validate, errors } = useForm({
    validationSchema: schema,
});

const [serviceName, serviceNameAttrs] = defineField("serviceName");
const [servicePrice, servicePriceAttrs] = defineField("servicePrice");

const emit = defineEmits(["serviceAdded"]);

const modalElement = useTemplateRef("serviceAddModalRef");
const bootstrapModalInstance = ref<Modal | null>(null);

async function addService() {

    const result = await validate();

    if (!result.valid) {

        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Please check all fields and fill them correctly!"
        });

        return;
    }

    try {

        const { data } = await axiosInstance.post("/api/v1/admin/services", {
            name: serviceName.value,
            price: servicePrice.value,
        });

        if (data.success) {

            emit("serviceAdded");

            Swal.fire({
                icon: "success",
                title: data.message,
            });

            bootstrapModalInstance.value?.hide();
        }
    }

    catch (error) {
        console.log(error);
    }
}

onMounted(() => {
    bootstrapModalInstance.value = new Modal(modalElement.value, {});
    modalElement.value?.addEventListener('hidden.bs.modal', () => {
        resetForm({
            values: {
                serviceName: "",
                servicePrice: null
            },
            touched: {
                serviceName: false,
                servicePrice: false
            },
            errors: {}
        });
    });
});

</script>