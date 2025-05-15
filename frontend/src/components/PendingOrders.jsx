import { useEffect, useState } from 'react';
import { getPendingOrders, cancelOrder } from '../api';

export default function PendingOrders() {
    const [orders, setOrders] = useState([]);

    const fetchPending = async () => {
        try {
            const res = await getPendingOrders();
            setOrders(Array.isArray(res.data) ? res.data : []);
        } catch (e) {
            console.error('Erreur récupération commandes en attente', e);
            setOrders([]);
        }
    };

    const handleCancel = async (orderId) => {
        if (!confirm('Annuler cette commande ?')) return;
        try {
            await cancelOrder(orderId);
            fetchPending();
        } catch (e) {
            console.error('Erreur lors de l\'annulation', e);
            alert("Erreur lors de l'annulation");
        }
    };

    useEffect(() => {
        fetchPending();
        const interval = setInterval(fetchPending, 3000);
        return () => clearInterval(interval);
    }, []);

    if (orders.length === 0) return null;

    return (
        <div style={{ width: '45%' }}>
            <h3>🕒 Commandes en attente</h3>
            <ul>
                {orders.map((order) => (
                    <li key={order.id}>
                        {order.size} - Intensité : {order.intensity}
                        <button
                            onClick={() => handleCancel(order.id)}
                            style={{ marginLeft: '10px' }}
                        >
                            ❌
                        </button>
                    </li>
                ))}
            </ul>
        </div>
    );
}
