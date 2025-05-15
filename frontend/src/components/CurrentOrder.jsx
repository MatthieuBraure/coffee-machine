import { useEffect, useState } from 'react';
import { getProcessingOrder, cancelOrder } from '../api';

export default function CurrentOrder() {
    const [order, setOrder] = useState(null);

    const fetchOrder = async () => {
        try {
            const res = await getProcessingOrder();
            if (res.data?.id) {
                setOrder(res.data);
            } else {
                setOrder(null);
            }
        } catch (e) {
            console.error('Erreur récupération commande en cours', e);
            setOrder(null);
        }
    };

    const handleCancel = async () => {
        if (!order?.id) return;
        if (!confirm('Annuler cette commande ?')) return;

        try {
            await cancelOrder(order.id);
            setOrder(null); // ou fetchOrder() pour recharger
        } catch (e) {
            console.error('Erreur lors de l\'annulation', e);
            alert("Erreur lors de l'annulation");
        }
    };

    useEffect(() => {
        fetchOrder();
        const interval = setInterval(fetchOrder, 3000);
        return () => clearInterval(interval);
    }, []);

    if (!order?.id) return null;

    return (
        <div style={{ width: '45%' }}>
            <h3>
                ⏳ Commande en cours
                <button onClick={handleCancel} style={{ marginLeft: '10px' }}>❌</button>
            </h3>
            <p><strong>Taille :</strong> {order.size}</p>
            <p><strong>Intensité :</strong> {order.intensity}</p>
            <p><strong>Depuis :</strong> {new Date(order.createdAt.date).toLocaleString()}</p>
        </div>
    );
}
