import { create } from 'zustand';
import { devtools, persist } from 'zustand/middleware';
interface AuthStoreState {
  token: string;
  setToken: (token: string) => void;
}

export const useAuthStore = create<AuthStoreState>()(
  devtools(
    persist(
      (set) => ({
        token: '',
        setToken: (token) => set({ token })
      }),
      {
        name: 'auth'
      }
    )
  )
);
