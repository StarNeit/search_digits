import React, { PropsWithChildren } from 'react';
import * as motion from 'motion/react-client';

const FadeIn: React.FC<PropsWithChildren & { frameKey: string }> = ({
  children,
  frameKey
}) => {
  return (
    <motion.div
      key={frameKey}
      initial={{ x: 100, opacity: 0 }}
      animate={{ x: 0, opacity: 1 }}
      exit={{ x: -100, opacity: 0 }}
      transition={{ duration: 0.5 }}>
      {children}
    </motion.div>
  );
};

export default FadeIn;
