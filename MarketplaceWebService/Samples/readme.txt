http://stackoverflow.com/questions/27424040/how-to-set-min-and-max-prices-for-products-using-amazon-mws-api/28341495#28341495
http://stackoverflow.com/questions/25894206/amazon-marketplace-php-pricing-api/25896053#25896053
http://stackoverflow.com/questions/23726937/amazon-mws-api-stack-order-of-post-product-data/23728013#23728013
http://stackoverflow.com/tags/amazon-mws/hot?filter=year
<?xml version="1.0" encoding="utf-8"?>
<AmazonEnvelope xsi:noNamespaceSchemaLocation="amzn-envelope.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <Header>
            <DocumentVersion>1.01</DocumentVersion>
                    <MerchantIdentifier>YOUR_ID</MerchantIdentifier>
                        </Header>
                            <MessageType>Price</MessageType>
                               <Message>
                                   <MessageID>1</MessageID>
                                   <Price>
                                       <SKU>YOUR_SKU</SKU>
                                           <StandardPrice currency="GBP">30.75</StandardPrice>
                                            <MinimumSellerAllowedPrice currency="GBP">20</MinimumSellerAllowedPrice>
                                                <MaximumSellerAllowedPrice currency="GBP">40</MaximumSellerAllowedPrice>
                                                </Price>
                                                </Message>
                                                </AmazonEnvelope>
