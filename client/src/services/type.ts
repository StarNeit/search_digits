import { PropertyTypes, TimeType } from '@types';

export type OnBoardingAPIRequest = {
  is_emergency: boolean;
  property_type: PropertyTypes | null;
  time: TimeType | null;
  email: string;
  phone: string;
  address: string;
};
