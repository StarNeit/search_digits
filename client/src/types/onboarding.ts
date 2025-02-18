export enum PropertyTypes {
  RESIDENTIAL_HOUSE = 'residential_house',
  COMMERCIAL_SHOP = 'commercial_shop',
  OFFICE_BUILDING = 'office_building',
  INDUSTRIAL_WAREHOUSE = 'industrial_warehouse'
}

export enum TimeType {
  MORNING = 'morning',
  AFTERNOON = 'afternoon',
  EVENING = 'evening',
  ANYTIME = 'anytime'
}

export type Contact = {
  email: string;
  phone: string;
  address: string;
};
