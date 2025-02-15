import {
  Card,
  CardFooter,
  CardHeader,
  Progress
} from '@material-tailwind/react';

const OPTIONS = [
  {
    label: 'Residential House',
    icon: (
      <svg
        className="w-16 h-16"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24">
        <defs></defs>
        <title>house</title>
        <path d="M3.75,13.939v8.25h6v-6a1.5,1.5,0,0,1,1.5-1.5h1.5a1.5,1.5,0,0,1,1.5,1.5v6h6v-8.25"></path>
        <path d="M.75,12.439,10.939,2.25a1.5,1.5,0,0,1,2.122,0L23.25,12.439"></path>
        <polyline points="16.5 5.689 16.5 4.189 20.25 4.189 20.25 9.439"></polyline>
        <line x1="1.5" y1="22.189" x2="22.5" y2="22.189"></line>
      </svg>
    )
  },
  {
    label: 'Commercial Shop',
    icon: (
      <svg
        className="w-16 h-16"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24">
        <defs></defs>
        <title>shop-cart</title>
        <path d="M21.148.75H2.852a.751.751,0,0,0-.733.587L.75,7.5a2.25,2.25,0,0,0,4.5,0,2.25,2.25,0,0,0,4.5,0,2.25,2.25,0,0,0,4.5,0,2.25,2.25,0,0,0,4.5,0,2.25,2.25,0,0,0,4.5,0L21.88,1.337A.749.749,0,0,0,21.148.75Z"></path>
        <line x1="21.75" y1="23.25" x2="21.75" y2="12.75"></line>
        <line x1="2.25" y1="12.75" x2="2.25" y2="23.25"></line>
        <path d="M15.749,17.25H8.078a1.5,1.5,0,0,0-1.4,2.026l1.308,3.487a.748.748,0,0,0,.7.487h6.46a.751.751,0,0,0,.7-.487l1.307-3.487A1.5,1.5,0,0,0,15.749,17.25Z"></path>
        <line x1="8.163" y1="17.25" x2="9.663" y2="13.5"></line>
        <line x1="15.663" y1="17.25" x2="14.163" y2="13.5"></line>
        <line x1="10.5" y1="21" x2="10.5" y2="19.5"></line>
        <line x1="13.5" y1="21" x2="13.5" y2="19.5"></line>
      </svg>
    )
  },
  {
    label: 'Office Building',
    icon: (
      <svg
        className="w-16 h-16"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24">
        <defs></defs>
        <title>antenna-tower</title>
        <line x1="0.75" y1="23.25" x2="21" y2="23.25"></line>
        <path d="M9.75,23.25h-9V7.992a.5.5,0,0,1,.5-.492h8a.5.5,0,0,1,.5.492Z"></path>
        <path d="M7.5,5.144A.7.7,0,0,0,6.75,4.5h-3A.7.7,0,0,0,3,5.144V7.5H7.5Z"></path>
        <line x1="5.25" y1="4.5" x2="5.25" y2="0.75"></line>
        <line x1="3.75" y1="10.5" x2="6.75" y2="10.5"></line>
        <line x1="3.75" y1="13.5" x2="6.75" y2="13.5"></line>
        <line x1="3.75" y1="16.5" x2="6.75" y2="16.5"></line>
        <line x1="3.75" y1="19.5" x2="6.75" y2="19.5"></line>
        <path d="M12.906,5.421a5.961,5.961,0,0,1,5.829,5.829"></path>
        <path d="M13.905.764a9.751,9.751,0,0,1,9.33,9.288"></path>
        <path d="M17.25,14.25H13.5a.75.75,0,0,0-.75.75v8.25H18V15A.75.75,0,0,0,17.25,14.25Z"></path>
      </svg>
    )
  },
  {
    label: 'Industrial Warehouse',
    icon: (
      <svg
        className="w-16 h-16"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24">
        <defs></defs>
        <title>water-dam</title>
        <path d="M15,13.5l4.915-2.457A.75.75,0,0,1,21,11.714V21.75a1.5,1.5,0,0,1-1.5,1.5H3a1.5,1.5,0,0,1-1.5-1.5V13.5L3.623,3.593A.75.75,0,0,1,4.356,3H6.144a.75.75,0,0,1,.733.593L9,13.5l4.915-2.457A.75.75,0,0,1,15,11.714V13.5"></path>
        <line x1="9" y1="17.25" x2="12" y2="17.25"></line>
        <line x1="9" y1="20.25" x2="12" y2="20.25"></line>
        <line x1="15" y1="17.25" x2="18" y2="17.25"></line>
        <line x1="15" y1="20.25" x2="18" y2="20.25"></line>
        <path d="M9.005.869A6.954,6.954,0,0,1,12,1.491C19.429,4.662,22.5.75,22.5.75"></path>
      </svg>
    )
  }
];

const TypeOfProperty = () => {
  const handleSelectProperty = () => {
    window.location.hash = '#question-4';
  };

  return (
    <div>
      <Progress value={66} size="sm" color="red" />
      <div className="pt-4 md:pt-8">
        <p className="text-sm text-red-800 mb-1 md:mb-4 font-semibold">
          Question 2 of 3
        </p>
        <h2 className="text-base md:text-lg font-semibold text-black">
          What type of property is this for?
        </h2>
      </div>

      <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 pt-6 max-h-[60vh] overflow-auto">
        {OPTIONS.map((opt, index) => (
          <Card
            key={index}
            onClick={handleSelectProperty}
            className="w-full p-0 shadow-none border border-gray-200 cursor-pointer hover:shadow">
            <CardHeader
              shadow={false}
              floated={false}
              className="h-32 md:h-40 p-0 m-0 flex items-center justify-center bg-gray-100">
              {opt.icon}
            </CardHeader>
            <CardFooter className="pt-6 px-0 md:px-1 text-black text-center text-sm md:text-base font-semibold md:font-bold">
              {opt.label}
            </CardFooter>
          </Card>
        ))}
      </div>
    </div>
  );
};

export default TypeOfProperty;
