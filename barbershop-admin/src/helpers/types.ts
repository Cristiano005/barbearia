interface CustomerInterface {
    id: number,
    name: string,
    email: string,
};

interface ScheduleInterface {
    id: number,
    user: {
        name: string,
        email: string,
    }
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

interface ServiceInterface {
    id: number,
    name: string,
    price: string,
}

interface PaymentTypeInterface {
    id: number,
    payment_type: string,
}

interface AvailableDateTimesInterface {
    id: number,
    date: String,
    time: String,
};

interface FetchServicesParams {
    currentPage?: number;
    all?: boolean;
}

interface StatusStyle {
    icon: string;
    color: string;
};

interface StatusColorsInterface {
    success: StatusStyle,
    pending: StatusStyle,
    absent: StatusStyle,
    cancelled: StatusStyle
};

interface PaginationInterface {
    quantityOfPages: number,
    currentPage: number,
};

export type {
    CustomerInterface, ScheduleInterface, ServiceInterface, PaymentTypeInterface,
    AvailableDateTimesInterface, FetchServicesParams, StatusColorsInterface, PaginationInterface
}