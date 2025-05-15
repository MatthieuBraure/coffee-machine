import { useEffect, useState } from 'react';
import MachineStatus from './components/MachineStatus';
import OrderForm from './components/OrderForm';
import PendingOrders from './components/PendingOrders';
import CurrentOrder from './components/CurrentOrder';
import OrderHistory from './components/OrderHistory';
import { getMachineStatus } from './api';
function App() {
  const [machineStatus, setMachineStatus] = useState(null);

  const refreshStatus = async () => {
    const res = await getMachineStatus();
    setMachineStatus(res.data.status); // ex: "ready", "running", etc.
  };

  useEffect(() => {
    refreshStatus();
    const interval = setInterval(refreshStatus, 3000);
    return () => clearInterval(interval);
  }, []);
  return (
    <div style={{ padding: '2rem' }}>
      <h1>Machine à café connectée ☕</h1>
      <MachineStatus status={machineStatus} onRefresh={refreshStatus} />
      {['ready', 'running'].includes(machineStatus) && <CurrentOrder />}
      {['ready', 'running'].includes(machineStatus) && <OrderForm />}
      <PendingOrders />
      <OrderHistory />
    </div>
  );
}

export default App;
