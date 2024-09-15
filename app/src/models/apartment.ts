import type {PriceCategory} from "@/enums/priceCategory";
import type {City} from "@/enums/city";

export class Apartment {
    public id: number | null;
    public nbRooms: number | null;
    public surface: number | null;
    public nbWindows: number | null;
    public price: number | null;
    public year: number | null;
    public balcony: boolean = false;
    public garage: boolean = false;
    public note: number = 1;
    public priceCategory: PriceCategory | null = null;
    public city: City | null = null;

    constructor(
        id: number | null = null,
        nbRooms: number | null = null,
        surface: number | null = null,
        nbWindows: number | null = null,
        price: number | null = null,
        year: number | null = null,
        balcony: boolean = false,
        garage: boolean = false,
        note: number = 1,
        priceCategory: PriceCategory | null = null,
        city: City | null = null,
    ) {
        this.id = id
        this.nbRooms = nbRooms
        this.surface = surface
        this.nbWindows = nbWindows
        this.price = price
        this.year = year
        this.balcony = balcony
        this.garage = garage
        this.note = note
        this.priceCategory = priceCategory
        this.city = city
    }
}