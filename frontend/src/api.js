import axios from 'axios';

const API = axios.create({
  baseURL: 'https://localhost/api', // adapte selon ta config Symfony
});

export const getMachineStatus = () => API.get('/coffee-machine/status');
export const startMachine = () => API.post('/coffee-machine/start');
export const stopMachine = () => API.post('/coffee-machine/stop');

export const getProcessingOrder = () => API.get('/coffee/processing');
export const getCompletedOrders = () => API.get('/coffee/completed');
export const getPendingOrders = () => API.get('/coffee/pending');
export const createOrder = (data) => API.put('/coffee/order', data);
export const cancelOrder = (id) => API.post(`/coffee/${id}/cancel`);

