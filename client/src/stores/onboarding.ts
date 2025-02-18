import { create } from 'zustand';
import { devtools } from 'zustand/middleware';
import { Contact, PropertyTypes, TimeType } from '@types';

interface OnBoardingStoreState {
  is_emergency: boolean;
  property_type: PropertyTypes | null;
  time: TimeType | null;
  email: string;
  phone: string;
  address: string;
  setIsEmergency: (value: boolean) => void;
  setPropertyType: (value: PropertyTypes) => void;
  setTime: (time: TimeType) => void;
  setContactInformation: (contact: Contact) => void;
}

export const useOnBoardingStore = create<OnBoardingStoreState>()(
  devtools(
    (set) => ({
      is_emergency: false,
      property_type: null,
      time: null,
      email: '',
      address: '',
      phone: '',
      setIsEmergency: (value: boolean) => {
        set({ is_emergency: value });
      },
      setPropertyType: (value: PropertyTypes | null) => {
        set({ property_type: value });
      },
      setTime: (time: TimeType | null) => {
        set({ time: time });
      },
      setContactInformation: (contact: Contact) => {
        set({
          email: contact.email,
          phone: contact.phone,
          address: contact.address
        });
      }
    }),
    {
      name: 'onboarding'
    }
  )
);
