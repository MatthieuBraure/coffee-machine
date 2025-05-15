import { useEffect, useState } from 'react';
import { getCompletedOrders } from '../api';

export default function OrderHistory() {
    const [completedOrders, setCompletedOrders] = useState([]);

    const fetchCompletedOrders = async () => {
        try {
            const orders = await getCompletedOrders();
            setCompletedOrders(Array.isArray(orders.data) ? orders.data : []);
        } catch (err) {
            console.error('Erreur lors de la récupération des commandes terminées', err);
        }
    };

    useEffect(() => {
        fetchCompletedOrders();
        const interval = setInterval(fetchCompletedOrders, 3000);
        return () => clearInterval(interval);
    }, []); // Appel une seule fois au démarrage

    if (!completedOrders.length) {
        return <p>Aucune commande terminée.</p>;
    }

    return (
        <div>
            <h3>Historique des commandes</h3>
            <ul>
                {completedOrders.map((order) => (
                    <li key={order.id}>
                        <strong>Taille :</strong> {order.size} <br />
                        <strong>Intensité :</strong> {order.intensity} <br />
                        <strong>Date :</strong> {new Date(order.updatedAt.date).toLocaleString()} <br />
                    </li>
                ))}
            </ul>
        </div>
    );
}
