import axios, { AxiosResponse } from 'axios';
import { APIRequest, APIResponse } from './type';

export const fetchData = (
  payload: APIRequest
): Promise<AxiosResponse<APIResponse>> => {
  return axios.post<APIResponse>('/', payload);
};
