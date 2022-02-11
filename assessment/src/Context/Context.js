import React, {
    createContext,
    useContext,
    useState,
    useMemo,
    useEffect,

  } from "react";

  import {
    collection,
    addDoc,
    updateDoc,
    deleteDoc,
    doc,
    query,
    onSnapshot,

  } from "firebase/firestore";

  import { firestore } from "./FirebaseContext";
  
  const UserContext = createContext();
  
  export const UserContextProvider = ({ children }) => {
    const [users, setUsers] = useState([]);
  
    
    useEffect(() => {
      
      const q = query(collection(firestore, "Users"));
      const unsubscribe = onSnapshot(q, (querySnapshot) => {
        setUsers(
          querySnapshot.docs.map((doc) => {
            return { id: doc.id, ...doc.data() };
          })
        );
      });
  
      return () => unsubscribe;
    }, []);


//   CREATE

    const addUser = async (data) => {
      addDoc(collection(firestore, "Users"), data);
  
      return new Promise((resolve, reject) => {
        addDoc(collection(firestore, "Users"), data)
          .then(() => {
            resolve();
          })
          .catch((err) => reject(err));
      });
    };
    
//   UPDATE
  
    const updateUser = async (data) => {
      await updateDoc(doc(firestore, "Users", data.id), data);
    };
  
 //   DELETE
    const deleteUser = async (data) => {
      await deleteDoc(doc(firestore, "Users", data.id));
    };
  
    const payload = useMemo(
      () => ({ users, addUser, updateUser, deleteUser }),
      [users]
    );
    return (
      <UserContext.Provider value={payload}>{children}</UserContext.Provider>
    );
  };
  
  export const useUserContext = () => useContext(UserContext);