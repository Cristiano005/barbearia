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
    ScheduleInterface, ServiceInterface, FetchServicesParams, StatusColorsInterface, PaginationInterface
}