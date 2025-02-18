import axios, { AxiosResponse } from 'axios';
import { OnBoardingAPIRequest } from './type';

export const completeOnBoardingData = (
  payload: OnBoardingAPIRequest
): Promise<AxiosResponse> => {
  return axios.post('/onboarding', payload);
};
