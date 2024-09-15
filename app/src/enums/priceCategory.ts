export enum PriceCategory {
    LOW = "low",
    NORMAL = "normal",
    HIGH = "high",
    SCAM = "scam"
}

namespace PriceCategory {
    export function getSeverity(priceCategory: PriceCategory) {
        let severity = null
        console.log(priceCategory)
        switch (priceCategory){
            case PriceCategory.LOW:
                severity = "primary"
                break
            case PriceCategory.NORMAL:
                severity = "yellow"
                break
            case PriceCategory.HIGH:
                severity = "warn"
                break
            case PriceCategory.SCAM:
                severity = "danger"
                break
        }

        return severity
    }
}
