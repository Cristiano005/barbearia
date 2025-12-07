interface ServiceInterface {
    id: number,
    name: string,
    price: string,
};

interface ScheduleInterface {
    id: number,
    service: {
        id: number,
        name: string,
        price: string,
    },
    payment: string,
    status: "success" | "pending" | "absent" | "cancelled",
    date: string,
    time: string,
};

interface PaymentTypeInterface {
    id: number,
    payment_type: string,
};

interface AvailableDateTimesInterface {
    id: number,
    date: String,
    time: String,
};

interface ProfileDataInterface {
    name: string,
    email: string,
    phone_number: string,
    has_pending_schedule: boolean,
};

interface StatusColorsInterface {
    success: string,
    pending: string,
    absent: string,
    cancelled: string,
};

export type {
    ServiceInterface, ScheduleInterface, PaymentTypeInterface, AvailableDateTimesInterface,
    ProfileDataInterface, StatusColorsInterface
}