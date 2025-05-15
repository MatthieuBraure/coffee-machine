import { useState } from 'react';
import { createOrder } from '../api';

const sizes = [
    { value: 'ristretto', label: 'Ristretto' },
    { value: 'expresso', label: 'Expresso' },
    { value: 'regular', label: 'Regular' },
    { value: 'dopio', label: 'Dopio' },
    { value: 'lungo', label: 'Lungo' },
];

export default function OrderForm() {
    const [form, setForm] = useState({
        size: 'expresso',
        intensity: 5,
    });

    const [message, setMessage] = useState(null);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setForm((prev) => ({
            ...prev,
            [name]: name === 'intensity' ? parseInt(value) : value,
        }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            await createOrder(form);
            setMessage({ type: 'success', text: '✅ Commande envoyée !' });
            setForm({ size: 'expresso', intensity: 5 });
        } catch (err) {
            console.error(err);
            setMessage({ type: 'error', text: '❌ Erreur lors de la commande' });
        }
    };

    return (
        <form onSubmit={handleSubmit}>
            <h3>📦 Commander un café</h3>

            <label>Taille :</label>
            <select name="size" value={form.size} onChange={handleChange}>
                {sizes.map((s) => (
                    <option key={s.value} value={s.value}>{s.label}</option>
                ))}
            </select>

            <br /><br />

            <label>Intensité : <strong>{form.intensity}</strong></label>
            <input
                type="range"
                name="intensity"
                min={1}
                max={10}
                value={form.intensity}
                onChange={handleChange}
            />

            <br /><br />

            <button type="submit">☕ Commander</button>

            {message && (
                <p style={{ marginTop: '10px', color: message.type === 'success' ? 'green' : 'red' }}>
                    {message.text}
                </p>
            )}
        </form>
    );
}
