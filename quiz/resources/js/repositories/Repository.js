import Axios from "axios";
import { TokenHandler } from './../handlers/TokenHandler';

const baseURL = `/api`;

export const axios = Axios.create({
    baseURL,
    headers: {'Authorization': `Bearer ${TokenHandler.getToken()}`}
});