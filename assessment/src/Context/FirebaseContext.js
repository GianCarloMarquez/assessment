
import { initializeApp } from "firebase/app";
import {getFirestore} from "firebase/firestore";

const firebaseConfig = {
  apiKey: "AIzaSyA4YC0Ymj3vfseVDVqkcoAETOugPYjnGLM",
  authDomain: "assessment-78296.firebaseapp.com",
  projectId: "assessment-78296",
  storageBucket: "assessment-78296.appspot.com",
  messagingSenderId: "353224208598",
  appId: "1:353224208598:web:e00d7f16943c7203189977"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const firestore = getFirestore (app);

export {firestore, app} ;